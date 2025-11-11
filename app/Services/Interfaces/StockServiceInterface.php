<?php

namespace App\Services\Interfaces;

interface StockServiceInterface
{
    public function getAllStocks();
    public function getStockById($id);
    public function createStock(array $data);
    public function updateStock(array $data, $id);
    public function deleteStock($id);
}
