<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        try{
            // data chart : jumlah asset berdasarkan kategori
            $assetByCategory = Asset::select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->get();

            // data chart: jumlah aset berdasarkan status.
            $assetByStatus = Asset::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();

            // data tabel : daftar asset terbaru (5 terbaru)
            $latestAssets = Asset::with('location')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // data tabel : daftar transaksi terbaru (5 terbaru)
            $latestTransactions = Transaction::with(['asset', 'user', 'location'])
                ->orderBy('transaction_date', 'desc')
                ->take(5)
                ->get();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data dashboard berhasil diambil!',
                    'data' => [
                        'asset_by_category' => $assetByCategory,
                        'asset_by_statut' => $assetByStatus,
                        'latest_assets' => $latestAssets,
                        'latest_transactions' => $latestTransactions
                    ],
                ],200
            );
        }catch(Exception $e){
            Log::error("Error fetching dashboard data : " .$e->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal mengambil data dashboard!',
                    'error' => $e->getMessage()
                ],500
            );
        }
    }
}