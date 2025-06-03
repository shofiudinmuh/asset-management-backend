<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\MaintenanceResource;
use App\Http\Resources\MaintenanceCollection;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{

            $maintenance = Maintenance::with(['asset', 'technician'])->select('maintenances.*');
            return DataTables::of($maintenance)
                ->addColumn('asset_name', function($row){
                    return $row->asset->name ?? '-';
                })
                ->addColumn('technician_name', function($row){
                    return $row->technician->name ?? '-';
                })
                ->make(true);

            return response()->json([
                'success' => true,
                'message' => 'Data maintenance berhasil diambil!',
                // 'data' => new MaintenanceCollection($maintenance),
            ], 200);
        }catch(Exception $e){
            Log::error('Error fetching maintenance data : ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data maintenance',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceRequest $request)
    {
        try{
            $maintenance = Maintenance::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Maintenance berhasil disimpan!',
                'data' => new MaintenanceResource($maintenance),
            ], 201);
        }catch(Exception $e){
            Log::error("Error creating maintenance data :" . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data maintenance',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        try{
            return response()->json([
                'success' => true,
                'message' => 'Detail maintenance berhasil diambil.',
                'data' => new MaintenanceResource($maintenance),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching maintenance detail : ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail maintenance',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {
        try{
            $maintenance->update($request->validated());

            return response()->json([
                'success' => true,
                'message' =>'Maintenance berhasil diupdate',
                'data' => new MaintenanceResource($maintenance),
            ], 200);
        }catch(Exception $e){
            Log::error("Error updating maintenance data :" .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memeperbarui maintenance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        try{
            $maintenance->delete();

            return response()->json([
                'success' => true,
                'message' => 'Maintenance berhasil dihapus',
            ], 200);
        }catch(Exception $e){
            Log::error("Error deleting maintenance data" .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data maintenance',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}