<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CustomerServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAllCustomers();

        return response()->json([
            'status_code' => 200,
            'message' => 'successful',
            'data' => $customers
        ]);
    }

    public function show($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        return response()->json([
            'status_code' => 200,
            'message' => 'successful',
            'data' => $customer
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'domicile' => 'required|string',
            'gender' => 'required|string|in:Pria,Wanita'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => 422,
                'message' => $validator->errors()->first() ?: 'Validation error',
            ], 422);
        }
        $data = $request->only(['name', 'domicile', 'gender']);
        $customer = $this->customerService->createCustomer($data);

        return response()->json([
            'status_code' => 201,
            'message' => 'Data Berhasil dibuat',
            'data' => $customer
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'domicile' => 'required|string',
                'gender' => 'required|string|in:Pria,Wanita'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status_code' => 422,
                    'message' => $validator->errors()->first() ?: 'Validation error',
                ], 422);
            }
            $data = $request->only(['name', 'domicile', 'gender']);
            $customer = $this->customerService->updateCustomer($data, $id);

            return response()->json([
                'status_code' => 200,
                'message' => 'Data Berhasil diubah',
                'data' => $customer
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
            $this->customerService->deleteCustomer($id);

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
