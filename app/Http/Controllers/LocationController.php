<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Resources\LocationResource;
use App\Http\Resources\LocationCollection;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $perPage = $request->query('per_page', 10);
            $locations = Location::paginate($perPage);
            
            return response()->json([
                'success' => true,
                'message' => 'Data lokasi berhasil diambil.',
                'data' => new LocationCollection($locations),
            ], 200);
        }catch(Exception $e){
            Log::error('Error fetching locations: ' .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lokasi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        try{
            $location = Location::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Lokasi berhasil disimpan!',
                'data' => new LocationResource($location),
            ], 201);
        }catch(Exception $e){
            Log::error('Error creating location: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan lokasi!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        try{
            return response()->json([
                'success' => true,
                'message' => 'Detail location berhasil diambil.',
                'data' => new LocationResource($location),
            ], 200);
        }catch(Exception $e){
            Log::error('Error fetching location details :' .$e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail lokasi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        try{
            $location->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Lokasi berhasi diperbarui.',
                'data' => new LocationResource($location),
            ], 200);
        }catch(Exception $e){
            Log::error('Error updating location: ' .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui lokasi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        try{
            $location->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lokasi berhasi dihapus!',
            ], 200);
        }catch(Exception $e){
            Log::erro('Error deleting location : ' .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus lokasi!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}