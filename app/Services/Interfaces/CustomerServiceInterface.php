<?php

namespace App\Services\Interfaces;

interface CustomerServiceInterface
{
    public function getAllCustomers();
    public function getCustomerById($id);
    public function createCustomer(array $data);
    public function updateCustomer(array $data, $id);
    public function deleteCustomer($id);
}
