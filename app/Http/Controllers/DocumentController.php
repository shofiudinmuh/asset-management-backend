<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetDocument;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\DocumentCollection;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $perPage = $request->query('per_page', 10);
            $assetDocuments = AssetDocument::with('asset')->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data dokumen berhasil diambil!',
                'data' => new DocumentCollection($assetDocuments),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching asset document : " . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal mengambil data asset dokumen!',
                    'error' => $e->getMessage(),
                ], 500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        try{

            if (!$request->hasFile('file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan dalam request!',
                ], 422);
            }
            $filePath = $request->file('file')->store('asset_documents', 'public');

            $assetDocument = AssetDocument::create(
                [
                    'asset_id' => $request->asset_id,
                    'document_name' => $request->document_name,
                    'file_path' => $filePath,
                ]
                );
                
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Dokumen berhasil disimpan!',
                        'data' => new DocumentResource($assetDocument)
                    ], 201
                );
        }catch(Exception $e){
            Log::error("Error creating asset document : " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan dokument!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $assetDocument = AssetDocument::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail dokumen aset berhasil diambil.',
                'data' => new DocumentResource($assetDocument->load(['asset'])),
            ], 200);
        }catch (\Exception $e) {
            Log::error('Error fetching asset document details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail dokumen aset.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, $id)
    {
        try{
            $assetDocument = AssetDocument::findOrFail($id);

            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('asset_documents', 'public');
                $assetDocument->file_path = $path;
            }

            $assetDocument->asset_id = $request->input('asset_id');
            $assetDocument->document_name = $request->input('document_name');
            $assetDocument->save();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen asset berhasil diperbarui',
                'data' => new DocumentResource($assetDocument),
            ]);
        }catch(Exception $e){
            Log::error("Error updating asset document : " . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal memperbarui asset dokument!',
                    'error' => $e->getMessage(),
                ], 500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{

            $assetDocument = AssetDocument::findOrFail($id);
            if ($assetDocument->file_path) {
                Storage::disk('public')->delete($assetDocument->file_path);
            }

            $assetDocument->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus asset dokumen!',
            ], 200);
            
        }catch(Exception $e){
            Log::error("Gagal menghapus asset dokument : " . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal menghapus data asset!',
                    'error' => $e->getMessage(),
                ], 500
            );
        }
    }
}