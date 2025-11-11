<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use App\Services\Interfaces\CustomerServiceInterface;
use Exception;

use function PHPUnit\Framework\isEmpty;

class CustomerService implements CustomerServiceInterface
{
    protected $customerRepository;
    protected $saleRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, SaleRepositoryInterface $saleRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->saleRepository = $saleRepository;
    }

    public function getAllCustomers()
    {
        return $this->customerRepository->all();
    }

    public function getCustomerById($id)
    {
        $customer = $this->customerRepository->find($id);
        if (!$customer) {
            throw new Exception('Data tidak ditemukan', 404);
        }
        return $customer;
    }

    public function createCustomer(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function updateCustomer(array $data, $id)
    {
        $this->getCustomerById($id);
        return $this->customerRepository->update($data, $id);
    }

    public function deleteCustomer($id)
    {
        $this->getCustomerById($id);
        $has = $this->saleRepository->getByCustomer($id);
        if ($has->exists()) {
            throw new Exception('Customer masih memiliki transaksi', 422);
        }
        return $this->customerRepository->delete($id);
    }
}
