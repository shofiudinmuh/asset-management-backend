<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function search(Request $request){
        try {
            $query = User::query();
    
            if ($request->has('q')) {
                $query->where('name', 'like', '%' . $request->q . '%'); // ✅ FIXED: use $request->q
            }
    
            $users = $query->limit(10)->get(['id', 'name']); // ✅ LIMIT and SELECT columns only
    
            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diambil!',
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            Log::error("Error searching users data : " . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data users!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function index(Request $request)
        {
            try {
                
                return DataTables::of(User::select(['id', 'name', 'email', 'created_at']))->make(true);
                
                
            } catch(Exception $e) {
                Log::error("Error fetching users data: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data users!',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try{
            $user = User::create([
                'name' => $request->validated()['name'],
                'email' => $request->validated()['email'],
                'password' =>Hash::make($request->validated()['password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil disimpan!',
                'data' => new UserResource($user),
            ], 201);
        }catch(Exception $e){
            Log::error("Error creating user data : " .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data user!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function me(User $user)
    {

        try{
            $user = Auth::user();
            return response()->json([
                'success' =>true,
                'message' => 'Detail user berhasil diambil!',
                'data' => new UserResource($user),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching detail user data : " .$e->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Gagal mengambil detail user!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try{
            return response()->json([
                'success' =>true,
                'message' => 'Detail user berhasil diambil!',
                'data' => new UserResource($user),
            ], 200);
        }catch(Exception $e){
            Log::error("Error fetching detail user data : " .$e->getMessage());

            return response()->json([
                'success' => true,
                'message' => 'Gagal mengambil detail user!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try{
            $user->update([
                'name' => $request->validated()['name'],
                'email' => $request->validated()['email'],
                'password' => Hash::make($request->validated()['password']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil diupdate!',
                'data' => new UserResource($user),
            ], 200);
        }catch(Exception $e){
            Log::error("Error updating user data : " .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data user!',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus!'
            ], 200);
        }catch(Exception $e){
            Log::error("Error deleting user : " .$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}