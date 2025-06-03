<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function search(Request $request){
        try {
            $query = Supplier::query();
    
            if ($request->has('q')) {
                $query->where('name', 'like', '%' . $request->q . '%'); // ✅ FIXED: use $request->q
            }
    
            $suppliers = $query->limit(10)->get(['id', 'name']); // ✅ LIMIT and SELECT columns only
    
            return response()->json([
                'success' => true,
                'message' => 'Data supplier berhasil diambil!',
                'data' => $suppliers,
            ]);
        } catch (\Exception $e) {
            Log::error("Error searching supplier data : " . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data supplier!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function index(Request $request)
    {
        try{
            return DataTables::of(Supplier::select(['id', 'name', 'contact_person', 'phone', 'email', 'address']))->make(true);

            return response()->json([
                'success' => true,
                'message' => 'Data supplier berhasil diambil!',
                // 'data' => new SupplierCollection($suppliers),
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

            Log::info('Data yang diterima:', $request->all());
            $supplier->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui data supplier!',
                'data' => $supplier,
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
            $supplier->delete();

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