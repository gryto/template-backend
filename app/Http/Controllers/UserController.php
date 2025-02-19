<?php

namespace App\Http\Controllers;
use App\Helper\API;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function handlePhotoUpload(Request $req, $existingPhoto = null)
    {
        if ($req->hasFile('photo')) {
            // Delete existing photo if any
            if ($existingPhoto && File::exists('user/' . $existingPhoto)) {
                File::delete('user/' . $existingPhoto);
            }

            $filename = rand() . '_' . strtolower(str_replace(" ", "_", $req->name)) . '.' . $req->file('photo')->getClientOriginalExtension();
            $req->file('photo')->move('user', $filename);
            return $filename;
        }
        return $existingPhoto;
    }

    // Method for validation that can be reused
    private function validateUser(Request $req)
    {
        $req->validate([
            'name'  => 'required',
            'role'  => 'required',
            'email'  => 'required|email:rfc',
            'password'  => 'required',
        ]);
    }

    public function index()
    {
        $aksi = 'Mendapatkan Semua Users';
        $users = User::orderBy('name')->paginate(5);
        return API::withData(true, $aksi, $users);
    }

    public function checkPhotoRecognition($id)
    {
        $aksi = 'mendapatkan data photo recognition';
        $user = User::find($id);
        return API::withData(true, $aksi, $user->face);
    }

    public function indexAll()
    {
        $aksi = 'Mendapatkan Semua Users';
        $users = User::with(['Role'])->orderBy('name', 'desc')->get();
        // $users = User::with(['Role'])->orderBy('name', 'desc')->get();
        return API::withData(true, $aksi, $users);
    }

    public function find($id)
    {
        $aksi = 'Menemukan user';
        $user = User::with(['Role'])->find($id);
        if ($user) {
            return API::withData(true, $aksi, $user);
        } else {
            return API::withoutData(false, $aksi);
        }
    }

    public function search(Request $req)
    {
        $aksi = 'Mendapatkan hasil pencarian user';
        try {
            $user = User::query()
                ->orderBy($req->sort_by, $req->sort_order)
                ->when($req->name, fn($query) => $query->where('name', 'LIKE', '%' . $req->name . '%'))
                ->when($req->role, fn($query) => $query->where('role', $req->role))
                ->when($req->email, fn($query) => $query->where('email', 'LIKE', '%' .  $req->email . '%'))
                ->paginate($req->pagination)
                ->appends($req->only(['name', 'role', 'email', 'pagination', 'sort_by', 'sort_order']));

            return API::withData(true, $aksi, $user);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }
    

    public function register(Request $req)
    {
        $aksi = 'Tambah User';

        try {
            $this->validateUser($req);

            $param = [
                'id'         => rand(),
                'name'       => $req->name,
                'email'      => $req->email,
                'face'       => $req->face,
                'role'       => $req->id,
                'password'   => Hash::make($req->password),
                'photo'      => $this->handlePhotoUpload($req), // Handle photo upload
            ];

            User::create($req->all());
            return API::withoutData(true, $aksi);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }

    // public function register(Request $req)
    // {
    //     // Implementasi register di sini
    //     $req->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     $role = Role::find($req->role);
    //     if (!$role) {
    //         return response()->json(['error' => 'Role tidak ditemukan'], 400);
    //     }

    //     $user = User::create([
    //         'name' => $req->name,
    //         'email' => $req->email,
    //         'role' => $role->id,
    //         'password' => Hash::make($req->password),
    //     ]);

    //     return response()->json(['message' => 'User created successfully'], 201);
    // }

    public function update(Request $req, $id)
    {
        $aksi = 'Ubah User';
        $this->validateUser($req);

        try {
            $user = User::find($id);
            if (!$user) {
                return API::withoutData(false, $aksi, 400, 'User Tidak Ada');
            }

            $param = [
                'name'      => $req->name,
                'email'     => $req->email,
                'role'      => $req->role,
                'face'      => $req->face ?? $user->face,
                'password'  => $req->password ? Hash::make($req->password) : $user->password,
                'photo'     => $this->handlePhotoUpload($req, $user->photo), // Handle photo upload
            ];

            $user->update($param);
            return API::withData(true, $aksi, $user);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }

    public function getToken($id)
    {
        $aksi = 'membuat token';
        try {
            $user = User::find($id);
            if (!$user) {
                return API::withoutData(false, $aksi);
            }

            $token = rand();
            $user->update(['access' => $token]);
            return API::withData(true, $aksi, $token);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $aksi = 'Hapus User';
            $user = User::find($id);
            if (!$user) {
                return API::withoutData(false, $aksi, 400, 'User Tidak Ada');
            }

            // Delete photo if exists
            if (File::exists('user/' . $user->photo)) {
                File::delete('user/' . $user->photo);
            }

            $user->delete();
            return API::withoutData(true, $aksi);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }
}
