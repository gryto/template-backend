<?php

namespace Database\Seeders;

use App\Models\Access;
use App\Models\Layout;
use App\Models\Module;
use App\Models\Recognition;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 🌟 1️⃣ Buat Role
        $roles = ['superadmin', 'admin', 'pegawai'];
        foreach ($roles as $r) {
            Role::create(['name' => $r]);
        }

        // 🌟 2️⃣ Buat Modul
        $modules = [
            ['name' => 'Dashboard', 'route' => 'dashboard'],
            ['name' => 'Management Users', 'route' => 'users'],
            ['name' => 'Log Aktivitas', 'route' => 'log'],
            ['name' => 'Role', 'route' => 'role'],
            ['name' => 'Pengaturan Tampilan', 'route' => 'layout'],
        ];
        Module::insert($modules); // Bisa langsung insert karena arraynya sudah rapi

        // 🌟 3️⃣ Buat Access (Role ↔ Modul)
        $modules = Module::all();
        $roles = Role::all();
        foreach ($modules as $mod) {
            foreach ($roles as $role) {
                Access::create([
                    'roles_id'   => $role->id,
                    'modules_id' => $mod->id
                ]);
            }
        }

        // 🌟 4️⃣ Buat User Superadmin
        $superadmin = Role::where('name', 'superadmin')->first();
        User::create([
            'name'     => 'Helena Antoniette',
            'role'     => $superadmin->id, // ✅ Sesuai dengan struktur tabel
            'photo'    => null,
            'email'    => 'helena@gmail.com',
            'password' => Hash::make('123')
        ]);

        // 🌟 5️⃣ Buat Pengaturan Tampilan
        Layout::insert([
            'id'             => rand(),
            'app_name'       => 'APP',
            'short_app_name' => 'APP',
            'header'         => '1',
            'footer'         => '1'
        ]);

        Recognition::insert([
            'id'    => rand()
        ]);
    }
}
