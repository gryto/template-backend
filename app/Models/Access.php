<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    // Jika nama tabelnya bukan plural "accesses", sesuaikan menjadi "access"
    protected $table = 'access'; 

    protected $fillable = ['roles_id', 'modules_id', 'status', 'dashboard', 'graph', 'create', 'update', 'delete'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'modules_id');
    }
}
