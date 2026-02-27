<?php
namespace src\Models;

class InvoiceHistoryDBStorage extends DBStorage
{
    protected $table = 'InvoiceHistory';

    public function getAllWithDetails()
    {
        $sql = "SELECT ih.HistoryID, i.InvoiceNumber,
                       ih.OldAmount, ih.NewAmount,
                       a.FullName as ChangedBy,
                       DATE_FORMAT(ih.ChangeDate, '%d.%m.%Y %H:%i') as ChangeDate,
                       ih.ActionType,
                       (ih.NewAmount - ih.OldAmount) as Difference
                FROM InvoiceHistory ih
                JOIN Invoices i ON ih.InvoiceID = i.InvoiceID
                JOIN Accountants a ON ih.ChangedBy = a.AccountantID
                ORDER BY ih.ChangeDate DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getIdColumn()
    {
        return 'HistoryID';
    }
}