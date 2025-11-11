<?php

namespace App\Services;

use App\Repositories\Interfaces\SaleItemRepositoryInterface;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use App\Services\Interfaces\SaleServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SaleService implements SaleServiceInterface
{
    protected $saleRepository;
    protected $saleItemRepository;

    public function __construct(SaleRepositoryInterface $saleRepository, SaleItemRepositoryInterface $saleItemRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->saleItemRepository = $saleItemRepository;
    }

    public function getAllSales()
    {
        return $this->saleRepository->all();
    }

    public function getSaleById($id)
    {
        $sale =  $this->saleRepository->find($id);
        if (!$sale) {
            throw new Exception("Data tidak ditemukan", 404);
        }
        return $sale;
    }

    public function createSale(array $data)
    {
        DB::beginTransaction();
        try {
            $note = $this->saleRepository->generateNote();
            $saleData = [
                'id_note' => $note,
                'date' => $data['date'],
                'customer_id' => $data['customer_id'],
                'subtotal' => 0,
            ];
            $sale =  $this->saleRepository->create($saleData);


            if (isset($data['products']) && is_array($data['products'])) {
                $subtotal = 0;

                foreach ($data['products'] as $item) {
                    $itemData = [
                        'note' => $note,
                        'stock_code' => $item['code'],
                        'qty' => $item['qty'],
                    ];
                    $this->saleItemRepository->create($itemData);

                    $saleItem = $this->saleItemRepository->findStockByNoteAndCode($note, $item['code']);
                    if ($saleItem) {
                        $subtotal += $saleItem->stock->price * $item['qty'];
                    }
                }

                $this->saleRepository->update(['subtotal' => $subtotal], $note);
            }

            DB::commit();

            return $this->getSaleById($note);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Gagal membuat data penjualan: " . $e->getMessage(), 500);
        }
    }

    public function updateSale(array $data, $id)
    {
        DB::beginTransaction();

        try {
            $note = $id;
            $saleData = [];
            if (isset($data['date'])) {
                $saleData['date'] = $data['date'];
            }
            if (isset($data['customer_id'])) {
                $saleData['customer_id'] = $data['customer_id'];
            }

            if (!empty($saleData)) {
                $this->saleRepository->update($saleData, $id);
            }

            if (isset($data['products']) && is_array($data['products'])) {
                $this->saleItemRepository->delete($note);

                $subtotal = 0;
                foreach ($data['products'] as $item) {
                    $itemData = [
                        'note' => $note,
                        'stock_code' => $item['code'],
                        'qty' => $item['qty'],
                    ];

                    $this->saleItemRepository->create($itemData);

                    $saleItem = $this->saleItemRepository->findStockByNoteAndCode($note, $item['code']);
                    if ($saleItem) {
                        $subtotal += $saleItem->stock->price * $item['qty'];
                    }
                }

                $this->saleRepository->update(['subtotal' => $subtotal], $id);
            }

            DB::commit();

            return $this->getSaleById($id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Gagal mengubah data penjualan: " . $e->getMessage(), 500);
        }
    }

    public function deleteSale($id)
    {
        $this->getSaleById($id);
        return $this->saleRepository->delete($id);
    }

    public function getSalesByCustomer(string $customerId)
    {
        return $this->saleRepository->getByCustomer($customerId);
    }

    public function getSalesByDateRange(string $startDate, string $endDate)
    {
        return $this->saleRepository->getByDateRange($startDate, $endDate);
    }
}
