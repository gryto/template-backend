<?php

namespace App\Http\Controllers;
use App\Helper\API;
use App\Models\Access;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function indexAll()
    {
        $aksi = 'Mendapatkan Semua Users';
        $roles = Role::get();
        return API::withData(true, $aksi, $roles);
    }


    public function find($id)
    {
        $aksi = 'Menemukan role';
        try {
            // Hanya cari role berdasarkan ID tanpa relasi ke User / Access
            $role = Role::find($id);

            if (!$role) {
                return API::withoutData(false, $aksi, 404, 'Role tidak ditemukan');
            }

            return API::withData(true, $aksi, $role);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 500, $th->getMessage());
        }
    }

    public function create(Request $req)
    {
        $aksi = 'Tambah Role';
        $req->validate([
            'role_name' => 'required|string|max:255'
        ]);

        try {

            $param = [
                'id' => rand(),
                'name' => $req->role_name, //"name" -> nama tabel di database sedangkan role_name -> validasinya
            ];

            Role::create($param);
            return API::withoutData(true, $aksi);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }

    function update(Request $req, $id)
    {
        $aksi = 'Ubah Role';
        $req->validate([
            'role_name' => 'required|string|max:255'
        ]);

        try {
            $role = Role::find($id);
            if (!$role) {
                return API::withoutData(false, $aksi, 400, 'Role Tidak Ada');
            }

            $param = [
                'name' => $req->role_name,
            ];

            $role->update($param);
            return API::withData(true, $aksi, $role);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }

    function destroy($id)
    {
        $aksi = 'Hapus Role';
        $role = Role::find($id);
        if (!$role) {
            return API::withoutData(false, $aksi, 400);
        }
        $role->delete();
        return API::withoutData(true, $aksi);
    }
}
