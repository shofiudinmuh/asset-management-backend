<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

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
    public function login(Rrequest $request){
        try{
            $validateData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            $user = User::where('email', $validateData['email'])->first();

            if(!$user || !Hash::check($validateData['password'], $user->password)){
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah',
                    'errors' => ['credentials' => 'Email atau password tidak sesuai.']
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                ],
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat login!',
                'erros' => $e->getMessage(),
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