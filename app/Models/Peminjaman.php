<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    use HasFactory;
    public function anggota(){
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id');
    }
    public function petugas(){
        return $this->belongsTo(Petugas::class, 'petugas_id', 'id');
    }
    public function peminjaman_detail(){
        return $this->hasMany(Peminjaman_detail::class, 'peminjaman_id');
    }
    public function pengembalian(){
        return $this->hasMany(Pengembalian::class, 'peminjaman_id');
    }
    protected $fillable = [
        'tanggal_pinjam',
        'tanggal_kembali',
        'anggota_id',
        'petugas_id',
    ];
}
