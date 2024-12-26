<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['username', 'password', 'nama', 'telp', 'alamat'];
    protected $hidden = [
        'password',
    ];
    public function peminjaman(){
        return $this->hasMany(Peminjaman::class, 'petugas_id');
    }
    public function pengembalian(){
        return $this->hasMany(Pengembalian::class, 'petugas_id');
    }
}
