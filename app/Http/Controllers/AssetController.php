<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\AssetResource;
use App\Http\Resources\AssetCollection;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function search(Request $request){
        try {
            $query = Asset::query();
    
            if ($request->has('q')) {
                $query->where('name', 'like', '%' . $request->q . '%'); // ✅ FIXED: use $request->q
            }
    
            $users = $query->limit(10)->get(['id', 'name']); // ✅ LIMIT and SELECT columns only
    
            return response()->json([
                'success' => true,
                'message' => 'Data asset berhasil diambil!',
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            Log::error("Error searching asset data : " . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data asset!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function index(Request $request)
    {
        try{
            $assets = Asset::with(['location'])->select('assets.*');

            return DataTables::of($assets)
                ->addColumn('location_name', function($row){
                    return $row->location->name ?? '-';
                })
                ->make(true);

            return response()->json([
                'success' => true,
                'message' => 'Data aset berhasil diambil',
                // 'data' => new AssetCollection($assets),
            ], 200);
        }catch(Exception $e){
            Log::error('Error fetching assets: '. $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data aset',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssetRequest $request)
    {
        try{
            $asset = Asset::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Asset berhasil disimpan',
                'data' => new AssetResource($asset),
            ], 201);
        }catch(Exception $e){
            Log::error('Error creating asset: '. $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan asset!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        try{
            return response()->json([
                'success' => true,
                'message' => 'Detail asset berhasil diambil!',
                'data' => new AssetResource($asset),
            ], 200);
        }catch(Exception $e){
            Log::error('Error fetching asset details :' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail asset!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        try{
            $asset->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Asset berhasil diperbarui!',
                'data' => new AssetResource($asset),
            ], 200);
        }catch(Exception $e){
            Log::error('Error updating asset: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui asset',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        try{
            $asset->delete();

            return response()->json([
                'success' => true,
                'message' => 'Asset berhasil dihapus!',
            ], 200);
        }catch(Exception $e){
            Log::error('Error deleting asset :'. $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus asset!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}