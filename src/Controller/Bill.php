<?php
namespace App\Controllers;

use App\Models\BillDBStorage;
use App\Views\BillTemplate;

class Bill {
    public function getAll(): string 
    {
        $objTemplate = new BillTemplate();
        $storage = new BillDBStorage();
        $result = $storage->getAllBills();

        $template = $objTemplate->getBillTemplate($result);
        return $template;
    }    
    
    public function getForm( $id_rec=0 ) {
        $storage = new BillDBStorage();
        if ($id_rec > 0)    // это изменение записи
            $row = $storage->getRecord($id_rec);
        else
            $row = null;    // это вставка данных идет
        $clients = $storage->getClients();

        $objTemplate = new BillTemplate();
        $template = $objTemplate->getFormTemplate($row, $clients);
        return $template;
    }

    // Вставка новой записи после добавления данных в форме
    public function addBill($row)
    {
        $storage = new BillDBStorage();
        $result = $storage->addBill($row);
        return $result;
    }

    // Передача данных (изменение) после редактирования в форме
    public function editBill($row)
    {
        $storage = new BillDBStorage();
        $result = $storage->saveBill($row);
        return $result;
    }

    public function deleteBill($id_rec)
    {
        $storage = new BillDBStorage();
        $result = $storage->deleteBill($id_rec);
        return $result;    
    }
}