<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    public function pengarang(){
        return $this->belongsTo(Pengarang::class, 'pengarang_id');
    } 
    public function penerbit(){
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    } 
    public function rak(){
        return $this->belongsTo(Rak::class, 'kode_rak');
    } 
    public function peminjaman_detail(){
        return $this->hasMany(Peminjaman_detail::class, 'buku_id');
    }
    protected $fillable = [
        'buku',
        'tahun_terbit',
        'jumlah',
        'isbn',
        'pengarang_id',
        'penerbit_id',
        'kode_rak',
    ];
}
