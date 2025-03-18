<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionCollection;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $perPage = $request->query('per_page', 10);
            $transactions = Transaction::with(['asset', 'user', 'location'])->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Data transaksi berhasil diambil',
                'data' => new TransactionCollection($transactions),
            ], 200);
        }catch(Exception $e){
            Log::error('Error fetching transactions : ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data transaksi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        try{
            $transaction = Transaction::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasi ditambahkan!',
                'data' => new TransactionRecource($transaction),
            ], 201);
        }catch(Exception $e){
            Log::error("Error creating transaction : ". $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan transaksi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        try{
            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil diambil!',
                'data' => new TransactionResource($transaction->load(['asset', 'user', 'location'])),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching transaction detail : ". $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail transaksi!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        try{
            $transaction->update($request->validate());

            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui data transaksi!',
                'data' => new TransactionResource($transaction),
            ], 200);
        }catch(Exception $e){
            Log::error("Error updating transaction: ". $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data transaksi!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        try{
            $transaction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus!',
            ], 200);
        }catch(Exception $e){
            Log::error("Error deleting transaction : ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data transaksi!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}