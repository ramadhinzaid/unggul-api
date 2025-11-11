<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all()
    {
        return Customer::all();
    }

    public function find($id)
    {
        return Customer::find($id);
    }

    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function update(array $data, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return false;
        }
        $customer->update($data);
        return $customer;
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return false;
        }
        return Customer::destroy($id);
    }
}
