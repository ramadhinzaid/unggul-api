<?php

namespace App\Repositories;

use App\Models\SaleItem;
use App\Repositories\Interfaces\SaleItemRepositoryInterface;

class SaleItemRepository implements SaleItemRepositoryInterface
{

    public function findStockByNoteAndCode($note, $code)
    {
        return SaleItem::with('stock')->where(['note' => $note, 'stock_code' => $code])->first();
    }

    public function create(array $data)
    {
        return SaleItem::create($data);
    }

    public function delete($note)
    {
        $saleItem = SaleItem::where(['note' => $note]);
        if (!$saleItem) {
            return false;
        }
        return $saleItem->delete();
    }
}
