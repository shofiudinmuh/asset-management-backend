<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // REGISTER USER
    public function register(Request $request){
        try{
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|string|min:6|confirmed'
            ]);

            $user = User::create([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'password' => Hash::make($validateData['password'])
            ]);

            return response()->json([
                'succes' => true,
                'message' => 'Registrasi berhasil! Silakan login untuk melanjutkan.',
                'data' => new UserResource($user),
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat registrasi',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    // LOGIN USER
    public function login(LoginRequest $request){
        try{
            // $validateData = $request->validate([
            //     'email' => 'required|email',
            //     'password' => 'required|string'
            // ]);

            // // Cari user berdasarkan email
            // $user = User::where('email', $validateData['email'])->first();

            // // Jika email tidak ditemukan
            // if (!$user) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Email belum terdaftar!',
            //         'errors' => ['email' => 'Email belum terdaftar!']
            //     ], 401);
            // }

            // // Jika password salah
            // if (!Hash::check($validateData['password'], $user->password)) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Password salah!',
            //         'errors' => ['password' => 'Password yang dimasukkan salah!']
            //     ], 401);
            // }

            $request->authenticate();

            $request->session()->regenerate();

            $user = Auth::user();
            // Hapus token lama (agar hanya 1 token aktif per user)
            $user->tokens()->delete();

            // Buat token baru
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat login!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function profile(Request $request){
        try{
            return response()->json([
                'success' => true,
                'message' =>'Profile user ditemukan',
                'data' => new UserResouce($request->user()),
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data profil',
                'erros' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request){
        try{
            $request->user()->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil. Token berhasil dihapus',
                'data' => null
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout!',
                'errors' => $e-getMessage(),
            ], 500);
        }
    }
}