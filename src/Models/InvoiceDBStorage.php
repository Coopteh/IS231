<?php
namespace src\Models;

class InvoiceDBStorage extends DBStorage
{
    protected $table = 'Invoices';

    public function getByAccountant($accountantId)
    {
        $sql = "SELECT i.InvoiceID, i.InvoiceNumber, 
                       DATE_FORMAT(i.InvoiceDate, '%d.%m.%Y') as InvoiceDate,
                       s.SupplierName, d.DepartmentName, 
                       i.Amount, i.PaymentStatus, i.Description
                FROM Invoices i
                JOIN Suppliers s ON i.SupplierID = s.SupplierID
                JOIN Departments d ON i.DepartmentID = d.DepartmentID
                WHERE i.AccountantID = :accountantId AND i.IsDeleted = FALSE
                ORDER BY i.InvoiceDate DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['accountantId' => $accountantId]);
        return $stmt->fetchAll();
    }

    public function getBySupplier($supplierId)
    {
        $sql = "SELECT i.InvoiceNumber, 
                       DATE_FORMAT(i.InvoiceDate, '%d.%m.%Y') as InvoiceDate,
                       d.DepartmentName, a.FullName as AccountantName,
                       i.Amount, i.PaymentStatus, i.Description
                FROM Invoices i
                JOIN Departments d ON i.DepartmentID = d.DepartmentID
                JOIN Accountants a ON i.AccountantID = a.AccountantID
                WHERE i.SupplierID = :supplierId AND i.IsDeleted = FALSE
                ORDER BY i.InvoiceDate DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['supplierId' => $supplierId]);
        return $stmt->fetchAll();
    }

    public function getByDepartment($departmentId)
    {
        $sql = "SELECT i.InvoiceNumber, 
                       DATE_FORMAT(i.InvoiceDate, '%d.%m.%Y') as InvoiceDate,
                       s.SupplierName, a.FullName as AccountantName,
                       i.Amount, i.PaymentStatus, i.Description
                FROM Invoices i
                JOIN Suppliers s ON i.SupplierID = s.SupplierID
                JOIN Accountants a ON i.AccountantID = a.AccountantID
                WHERE i.DepartmentID = :departmentId AND i.IsDeleted = FALSE
                ORDER BY i.InvoiceDate DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['departmentId' => $departmentId]);
        return $stmt->fetchAll();
    }

    public function updateAmount($invoiceId, $newAmount, $changedBy)
    {
        try {
            $this->pdo->beginTransaction();
            
            // Получаем старую сумму
            $sql = "SELECT Amount FROM Invoices WHERE InvoiceID = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $invoiceId]);
            $oldAmount = $stmt->fetchColumn();
            
            if ($newAmount == 0) {
                // Мягкое удаление
                $sql = "UPDATE Invoices SET IsDeleted = TRUE, DeletedDate = NOW() WHERE InvoiceID = :id";
                $action = 'Удаление счета';
            } else {
                // Изменение суммы
                $sql = "UPDATE Invoices SET Amount = :amount, ModifiedDate = NOW() WHERE InvoiceID = :id";
                $action = 'Изменение суммы';
            }
            
            $stmt = $this->pdo->prepare($sql);
            if ($newAmount == 0) {
                $stmt->execute(['id' => $invoiceId]);
            } else {
                $stmt->execute(['amount' => $newAmount, 'id' => $invoiceId]);
            }
            
            // Запись в историю
            $sql = "INSERT INTO InvoiceHistory (InvoiceID, OldAmount, NewAmount, ChangedBy, ActionType)
                    VALUES (:invoiceId, :oldAmount, :newAmount, :changedBy, :actionType)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'invoiceId' => $invoiceId,
                'oldAmount' => $oldAmount,
                'newAmount' => $newAmount,
                'changedBy' => $changedBy,
                'actionType' => $action
            ]);
            
            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function create($data)
    {
        $sql = "INSERT INTO Invoices (InvoiceNumber, InvoiceDate, SupplierID, AccountantID, 
                                      DepartmentID, Amount, Description)
                VALUES (:number, :date, :supplierId, :accountantId, :departmentId, :amount, :description)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function getStatistics()
    {
        $sql = "SELECT 
                    COUNT(*) as TotalInvoices,
                    SUM(Amount) as TotalAmount,
                    AVG(Amount) as AverageAmount,
                    SUM(CASE WHEN PaymentStatus = 'Оплачен' THEN 1 ELSE 0 END) as PaidCount,
                    SUM(CASE WHEN PaymentStatus = 'Не оплачен' THEN 1 ELSE 0 END) as UnpaidCount,
                    SUM(CASE WHEN PaymentStatus = 'Частично оплачен' THEN 1 ELSE 0 END) as PartialCount,
                    SUM(CASE WHEN PaymentStatus = 'Оплачен' THEN Amount ELSE 0 END) as PaidAmount,
                    SUM(CASE WHEN PaymentStatus = 'Не оплачен' THEN Amount ELSE 0 END) as UnpaidAmount
                FROM Invoices 
                WHERE IsDeleted = FALSE";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch();
    }

    public function getIdColumn()
    {
        return 'InvoiceID';
    }
}