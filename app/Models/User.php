<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Kalau pakai Sanctum

class User extends Authenticatable
{

    use HasApiTokens, Notifiable;
    protected $table = 'users';
    protected $guarded = [
        'id'
    ];

    protected $hidden = ['password', 'remember_token']; // Sembunyikan password saat response JSON


    public function Role()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }
}
