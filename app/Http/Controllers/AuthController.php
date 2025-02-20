<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Role;
use App\Models\Access;
use App\Helper\API;

class AuthController extends Controller
{

    public function login(Request $req)
    {
        $aksi = 'Masuk';  // Variabel untuk pesan respon

        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            // Cek apakah user ada berdasarkan email
            $user = User::where('email', $req->email)->first();

            // Jika user tidak ditemukan atau password salah
            if (!$user || !Hash::check($req->password, $user->password)) {
                return API::withoutData(false, "$aksi - Password salah", 401);
            }

            // Cek apakah role user aktif
            $role = Role::find($user->role);
            if (!$role || $role->status == 'inactive') {
                return API::withoutData(false, 'Role Anda telah dinonaktifkan. Silakan hubungi admin.', 403);
            }

            // Generate token menggunakan Laravel Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            // Mengambil data akses berdasarkan role
            $data = [
                'user' => $user,
                'role' => Access::with(['module', 'role'])->where('roles_id', $user->role)->get(),
                'access_token' => $token, // Tambahkan token ke response
                'token_type' => 'Bearer'
            ];

            return API::withData(true, $aksi, $data);
        } catch (\Throwable $th) {
            return API::withoutData(false, "$aksi - Terjadi kesalahan", 500, $th->getMessage());
        }
    }



    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !\Hash::check($request->password, $user->password)) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //         'user' => $user
    //     ]);
    // }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
