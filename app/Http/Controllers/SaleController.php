<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaleResource;
use App\Services\Interfaces\SaleServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleServiceInterface $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {


        try {
            $sales = $this->saleService->getAllSales();

            return response()->json([
                'status_code' => 200,
                'message' => 'successful',
                'data' => SaleResource::collection($sales)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    public function show($id)
    {


        try {
            $sale = $this->saleService->getSaleById($id);

            return response()->json([
                'status_code' => 200,
                'message' => 'successful',
                'data' => new SaleResource($sale)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),
            ],  500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'customer_id' => 'required|string|exists:customers,id',
            'products' => 'nullable|array',
            'products.*.code' => 'required|string|exists:stocks,code',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 422,
                'message' => $validator->errors()->first() ?: 'Validation error',
            ], 422);
        }

        try {
            $data = $request->only(['date', 'customer_id', 'products',]);
            $sale = $this->saleService->createSale($data);

            return response()->json([
                'status_code' => 201,
                'message' => 'Data Berhasil dibuat',
                'data' => new SaleResource($sale),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),

            ], $e->getCode() ?: 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'customer_id' => 'required|string|exists:customers,id',
            'products' => 'nullable|array',
            'products.*.code' => 'required|string|exists:stocks,code',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 422,
                'message' => $validator->errors()->first() ?: 'Validation error',
            ], 422);
        }

        try {
            $data = $request->only(['date', 'customer_id', 'products',]);
            $sale = $this->saleService->updateSale($data, $id);

            return response()->json([
                'status_code' => 200,
                'message' => 'Data Berhasil diubah',
                'data' => new SaleResource($sale),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),

            ], $e->getCode() ?: 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->saleService->deleteSale($id);
            return response()->json([
                'status_code' => 200,
                'message' => 'Data Berhasil dihapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),

            ], $e->getCode() ?: 500);
        }
    }

    public function getSalesByCustomer($customerId)
    {


        try {
            $sales = $this->saleService->getSalesByCustomer($customerId);

            return response()->json([
                'status_code' => 200,
                'message' => 'successful',
                'data' => $sales
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    public function getSalesByDateRange($startDate, $endDate)
    {


        try {
            $sales = $this->saleService->getSalesByDateRange($startDate, $endDate);

            return response()->json([
                'status_code' => 200,
                'message' => 'successful',
                'data' => $sales
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }
}
