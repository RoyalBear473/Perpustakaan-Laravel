<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengembalian extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_pengembalian',
        'denda',
        'peminjaman_id',
        'anggota_id',
        'petugas_id'
    ];
    public function pengembalian_detail(){
        return $this->hasMany(Pengembalian_detail::class, 'pengembalian_id');
    }
    public function peminjaman(){
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id');
    }
    public function anggota(){
        return $this->belongsTo(Anggota::class, 'anggota_id', 'id');
    }
    public function petugas(){
        return $this->belongsTo(Petugas::class, 'petugas_id', 'id');
    }
}
