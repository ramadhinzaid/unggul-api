<?php

namespace App\Services;

use App\Repositories\Interfaces\StockRepositoryInterface;
use App\Services\Interfaces\StockServiceInterface;
use Exception;

class StockService implements StockServiceInterface
{
    protected $stockRepository;

    public function __construct(StockRepositoryInterface $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function getAllStocks()
    {
        return $this->stockRepository->all();
    }

    public function getStockById($id)
    {
        $stock = $this->stockRepository->find($id);
        if (!$stock) {
            throw new Exception('Data tidak ditemukan', 404);
        }
        return $stock;
    }

    public function createStock(array $data)
    {
        return $this->stockRepository->create($data);
    }

    public function updateStock(array $data, $id)
    {
        $this->getStockById($id);
        return $this->stockRepository->update($data, $id);
    }

    public function deleteStock($id)
    {
        $this->getStockById($id);
        return $this->stockRepository->delete($id);
    }
}
