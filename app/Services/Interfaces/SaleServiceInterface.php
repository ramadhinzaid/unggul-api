<?php

namespace App\Services\Interfaces;

interface SaleServiceInterface
{
    public function getAllSales();
    public function getSaleById($id);
    public function createSale(array $data);
    public function updateSale(array $data, $id);
    public function deleteSale($id);
    public function getSalesByCustomer(string $customerId);
    public function getSalesByDateRange(string $startDate, string $endDate);
}
