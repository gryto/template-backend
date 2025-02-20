<?php

namespace App\Http\Controllers;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Helper\API;

class ModuleController extends Controller
{

    function indexAll()
    {
        $aksi = 'Mendapatkan Semua Modules';
        $modules = Module::get();
        return API::withData(true, $aksi, $modules);
    }


    public function find($id)
    {
        $aksi = 'Menemukan role';
        try {
            // Hanya cari role berdasarkan ID tanpa relasi ke User / Access
            $module = Module::find($id);

            if (!$module) {
                return API::withoutData(false, $aksi, 404, 'Module tidak ditemukan');
            }

            return API::withData(true, $aksi, $module);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 500, $th->getMessage());
        }
    }

    public function create(Request $req)
    {
        $aksi = 'Tambah Module';
        $req->validate([
            'module' => 'required|string|max:255'
        ]);

        try {

            $param = [
                'id' => rand(),
                'modul' => $req->module, //"name" -> nama tabel di database sedangkan role_name -> validasinya
            ];

            Module::create($param);
            return API::withoutData(true, $aksi);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }


    function update(Request $req, $id)
    {
        $aksi = 'Ubah Module';
        $req->validate([
            'module' => 'required|string|max:255'
        ]);

        try {
            $module = Module::find($id);
            if (!$module) {
                return API::withoutData(false, $aksi, 400, 'Module Tidak Ada');
            }

            $param = [
                'modul' => $req->module,
            ];

            $module->update($param);
            return API::withData(true, $aksi, $module);
        } catch (\Throwable $th) {
            return API::withoutData(false, $aksi, 400, $th->getMessage());
        }
    }

    function destroy($id)
    {
        $aksi = 'Hapus Role';
        $module = Module::find($id);
        if (!$module) {
            return API::withoutData(false, $aksi, 400);
        }
        $module->delete();
        return API::withoutData(true, $aksi);
    }

}
