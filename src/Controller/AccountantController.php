<?php
namespace src\Controllers;

use src\Models\InvoiceDBStorage;
use src\Models\SupplierDBStorage;
use src\Models\DepartmentDBStorage;

class AccountantController
{
    protected function checkAuth()
    {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'accountant') {
            header('Location: /login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->checkAuth();
        
        $invoiceStorage = new InvoiceDBStorage();
        $invoices = $invoiceStorage->getByAccountant($_SESSION['user_id']);
        
        require_once __DIR__ . '/../Views/AccountantTemplate.php';
        $view = new \src\Views\AccountantTemplate();
        $view->dashboard($invoices);
    }

    public function statistics()
    {
        $this->checkAuth();
        
        $invoiceStorage = new InvoiceDBStorage();
        $statistics = $invoiceStorage->getStatistics();
        
        require_once __DIR__ . '/../Views/AccountantTemplate.php';
        $view = new \src\Views\AccountantTemplate();
        $view->statistics($statistics);
    }
}