<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\Interfaces\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{
    public function all()
    {
        return Sale::with('customer', 'saleItems.stock')->get();
    }

    public function find($id)
    {
        return Sale::with('customer', 'saleItems.stock')->where(['id_note' => $id])->firstOrFail();
    }

    public function create(array $data)
    {
        return Sale::create($data);
    }

    public function update(array $data, $id)
    {
        return Sale::where(['id_note' => $id])->update($data);
    }

    public function delete($id)
    {
        return Sale::where(['id_note' => $id])->delete();
    }

    public function getByCustomer(string $customerId)
    {
        return Sale::where(['customer_id' => $customerId]);
    }

    public function getByDateRange(string $startDate, string $endDate)
    {
        return Sale::with(['customer', 'saleItems.stock'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();
    }

    public function generateNote()
    {
        return Sale::generateNote();
    }
}
