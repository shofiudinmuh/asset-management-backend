<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetDocument;
use App\Http\Resources\DocumentCollection;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function show(AssetDocument $assetDocument)
    {
        try{
            return response()->json([
                'success' => true,
                'message' => 'Detail dokumen aset berhasil diambil.',
                'data' => new DocumentResource($assetDocument->load('asset')),
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
    public function update(UpdateDocumentRequest $request, AssetDocument $assetDocument)
    {
        try{
            // Jika ada file baru, hapus file lama dan upload file baru
            if($request->hasFile('file')){
                Storage::disk('public')->delete($assetDocument->file_path);
                $filePath = $request->file('file')->store('asset_documents', 'public');

                $assetDocument->file_path = $filePath;
            }

            $assetDocument->update([
                'document_name' => $request->document_name ?? $assetDocument->document_name,
                'file_path' => $filePath ?? $assetDocument->file_path,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Dokumen asset berhasil diperbarui!',
                'data' => new DocumentResource($assetDocument),
            ], 200);
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
    public function destroy(AssetDocument $assetDocument)
    {
        try{
            Storage::disk('public')->delete($assetDocument->file_path);

            $assetDocument->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Berhasil menghapus asset dokumen!',
                ], 200
            );
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