<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $perPage = $request->query('per_page', 10);
            $suppliers = Supplier::paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data supplier berhasil diambil!',
                'data' => new SupplierCollection($suppliers),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching supplier data :" . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data supplier!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try{
            $supplier = Supplier::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil disimpan!',
                'data' => new SupplierResource($supplier),
            ], 201);
        }catch(Exception $e){
            Log::error("Error creating supplier data : ". $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data supplier!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        try{
            return response()->json([
                'success' => true,
                'message' => 'Detail supplier berhasil diambil',
                'data' => new SupplierResource($supplier),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching supplier data :" . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail supplier',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier){
        try{
            $supplier->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui data supplier!',
                'data' => new SupplierResource($supplier),
            ], 200);
        }catch(Exception $e){
            Log::error("Error updating supplier data : " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data supplier!',
                'error' => $e->getMessage(),
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try{
            $location->delete();

            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil dihapus!',
            ], 200);
        }catch(Exception $e){
            Log::error("Error deleting supplier data : " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data supplier!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}