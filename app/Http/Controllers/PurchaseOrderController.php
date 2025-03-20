<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Http\Resources\PurchaseOrderCollection;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $perPage = $request->query('per_page', 10);

            $purchaseOrders = PurchaseOrder::with('supplier')->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data purchase order berhasil diambil!.',
                'data' => new PurchaseOrderCollection($purchaseOrders),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching purchase orders : " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data purchase order!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        try{
            $purchaseOrder = PurchaseOrder::create($request->validated());

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil menyimpan purchase order!',
                    'data' => new PurchaseOrderResource($purchaseOrder),
                ], 201
            );
        }catch(Exception $e){
            Log::error("Error creating purchase order : " . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal menyimpan purchase order!',
                    'error' => $e->getMessage(),
                ], 500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        try{
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Detail purchase order berhasil diambil!',
                    'data' => new PurchaseOrderResource($purchaseOrder->load('supplier')),
                ], 200
            );
        }catch(Exception $e){
            Log::error("Error fetching purchase order detail : " . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal mengambil detail purchase order!',
                    'error' => $e->getMessage(),
                ],500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        try{
            $purchaseOrder->update($request->validate());

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil memperbarui data purchase order!',
                    'data' => new PurchaseOrderResource($purchaseOrder),
                ], 200
            );
        }catch(Exception $e){
            Log::error("Error updating purchase order data : " . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal memperbarui data purchase order!',
                    'error' => $e->getMessage(),
                ],500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        try{
            $purchaseOrder->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Purchase order berhasil dihapus!',
                ], 200
            );
        }catch(Exception $e){
            Log::error("Error deleting purchase order : " . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Purchase order gagal dihapus!',
                    'error' => $e->getMessage(),
                ], 500
            );
        }


    }
}