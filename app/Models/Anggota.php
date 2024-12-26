<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jenis_kelamin', 'alamat', 'telp'];
    public function peminjaman(){
        return $this->hasMany(Peminjaman::class, 'Anggota_id');
    }
    public function pengembalian(){
        return $this->hasMany(Pengembalian::class, 'Anggota_id');
    }
}
