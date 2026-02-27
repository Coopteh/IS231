<?php
namespace src\Models;

class DepartmentDBStorage extends DBStorage
{
    protected $table = 'Departments';

    public function getIdColumn()
    {
        return 'DepartmentID';
    }
}
