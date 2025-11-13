<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockResource;
use App\Services\Interfaces\StockServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockServiceInterface $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        try {
            $stocks = $this->stockService->getAllStocks();

            return response()->json([
                'status_code' => 200,
                'message' => 'successful',
                'data' => StockResource::collection($stocks)
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
            $stock = $this->stockService->getStockById($id);

            return response()->json([
                'status_code' => 200,
                'message' => 'successful',
                'data' => new StockResource($stock)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),

            ], $e->getCode() ?: 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string',
                'name' => 'required|string',
                'category' => 'required|string',
                'price' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status_code' => 422,
                    'message' => $validator->errors()->first() ?: 'Validation error',
                ], 422);
            }
            $data = $request->only(['code', 'name', 'category', 'price']);
            $stock = $this->stockService->createStock($data);

            return response()->json([
                'status_code' => 201,
                'message' => 'Data Berhasil dibuat',
                'data' => new StockResource($stock)
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
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string',
                'name' => 'required|string',
                'category' => 'required|string',
                'price' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status_code' => 422,
                    'message' => $validator->errors()->first() ?: 'Validation error',
                ], 422);
            }
            $data = $request->only(['code', 'name', 'category', 'price']);
            $stock = $this->stockService->updateStock($data, $id);

            return response()->json([
                'status_code' => 200,
                'message' => 'Data Berhasil diubah',
                'data' => new StockResource($stock)
            ]);
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
            $this->stockService->deleteStock($id);

            return response()->json([
                'status_code' => 200,
                'message' => 'Data Berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode() ?: 500,
                'message' => $e->getMessage(),

            ], $e->getCode() ?: 500);
        }
    }
}
