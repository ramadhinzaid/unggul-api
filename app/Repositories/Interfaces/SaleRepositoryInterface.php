<?php

namespace App\Repositories\Interfaces;

interface SaleRepositoryInterface
{
    public function all();
    public function find(string $id);
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function getByCustomer(string $customerId);
    public function getByDateRange(string $startDate, string $endDate);
    public function generateNote();
}
