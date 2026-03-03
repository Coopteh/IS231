<?php
namespace src\Controllers;

use src\Models\InvoiceDBStorage;
use src\Models\InvoiceHistoryDBStorage;
use src\Models\SupplierDBStorage;
use src\Models\DepartmentDBStorage;

class InvoiceController
{
    protected function checkAuth()
    {
        if (!isset($_SESSION['user_type'])) {
            header('Location: /login');
            exit;
        }
    }

    public function accountantInvoices()
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'accountant') {
            header('Location: /supplier/dashboard');
            exit;
        }

        $storage = new InvoiceDBStorage();
        $invoices = $storage->getByAccountant($_SESSION['user_id']);
        
        require_once __DIR__ . '/../Views/InvoiceTemplate.php';
        $view = new \src\Views\InvoiceTemplate();
        $view->accountantInvoices($invoices);
    }

    public function supplierMyInvoices()
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'supplier') {
            header('Location: /accountant/dashboard');
            exit;
        }

        $storage = new InvoiceDBStorage();
        $invoices = $storage->getBySupplier($_SESSION['user_id']);
        
        require_once __DIR__ . '/../Views/InvoiceTemplate.php';
        $view = new \src\Views\InvoiceTemplate();
        $view->supplierInvoices($invoices);
    }

    public function supplierInvoices($supplierId)
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'accountant') {
            header('Location: /login');
            exit;
        }

        $storage = new InvoiceDBStorage();
        $invoices = $storage->getBySupplier($supplierId);
        
        $supplierStorage = new SupplierDBStorage();
        $supplier = $supplierStorage->getById($supplierId);
        
        require_once __DIR__ . '/../Views/InvoiceTemplate.php';
        $view = new \src\Views\InvoiceTemplate();
        $view->supplierInvoicesList($invoices, $supplier);
    }

    public function departmentInvoices($departmentId)
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'accountant') {
            header('Location: /login');
            exit;
        }

        $storage = new InvoiceDBStorage();
        $invoices = $storage->getByDepartment($departmentId);
        
        $deptStorage = new DepartmentDBStorage();
        $department = $deptStorage->getById($departmentId);
        
        require_once __DIR__ . '/../Views/InvoiceTemplate.php';
        $view = new \src\Views\InvoiceTemplate();
        $view->departmentInvoices($invoices, $department);
    }

    public function editInvoice($invoiceId)
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'accountant') {
            header('Location: /login');
            exit;
        }

        $storage = new InvoiceDBStorage();
        $invoice = $storage->getById($invoiceId);
        
        require_once __DIR__ . '/../Views/InvoiceTemplate.php';
        $view = new \src\Views\InvoiceTemplate();
        $view->editInvoice($invoice);
    }

    public function updateInvoice($invoiceId)
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'accountant') {
            header('Location: /login');
            exit;
        }

        $newAmount = $_POST['amount'] ?? 0;
        
        $storage = new InvoiceDBStorage();
        $storage->updateAmount($invoiceId, $newAmount, $_SESSION['user_id']);
        
        $_SESSION['message'] = 'Счет успешно обновлен';
        header('Location: /accountant/invoices');
    }

    public function addInvoice()
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'accountant') {
            header('Location: /login');
            exit;
        }

        $supplierStorage = new SupplierDBStorage();
        $suppliers = $supplierStorage->getAll('SupplierName');
        
        $deptStorage = new DepartmentDBStorage();
        $departments = $deptStorage->getAll('DepartmentName');
        
        require_once __DIR__ . '/../Views/InvoiceTemplate.php';
        $view = new \src\Views\InvoiceTemplate();
        $view->addInvoice($suppliers, $departments);
    }

    public function storeInvoice()
    {
        $this->checkAuth();
        if ($_SESSION['user_type'] != 'accountant') {
            header('Location: /login');
            exit;
        }

        $data = [
            'number' => $_POST['number'],
            'date' => $_POST['date'],
            'supplierId' => $_POST['supplier_id'],
            'accountantId' => $_SESSION['user_id'],
            'departmentId' => $_POST['department_id'],
            'amount' => $_POST['amount'],
            'description' => $_POST['description']
        ];

        $storage = new InvoiceDBStorage();
        $storage->create($data);
        
        $_SESSION['message'] = 'Счет успешно добавлен';
        header('Location: /accountant/invoices');
    }
}