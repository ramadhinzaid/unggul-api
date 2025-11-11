<?php

namespace App\Repositories;

use App\Models\Stock;
use App\Repositories\Interfaces\StockRepositoryInterface;

class StockRepository implements StockRepositoryInterface
{
    public function all()
    {
        return Stock::all();
    }

    public function find($id)
    {
        return Stock::where(['id' => $id])->orWhere(['code' => $id])->first();
    }

    public function create(array $data)
    {
        return Stock::create($data);
    }

    public function update(array $data, $id)
    {
        return $this->find($id)->update($data);
    }

    public function delete($id)
    {
        return Stock::destroy($id);
    }
}
