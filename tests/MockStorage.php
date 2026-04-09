<?php
namespace Test;
use App\Services\IStorage;

class MockStorage implements IStorage
{    
    public function loadData(string $name): ?array
    {
        // оставьте метод пустым, мы напишем реализацию позже
        return [];
    }
    public function saveData(string $name, array $data): bool
    {
        // оставьте метод пустым, мы напишем реализацию позже
        return true;
    }  
  
}