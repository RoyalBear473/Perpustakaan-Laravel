<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengarang extends Model
{
    use HasFactory;
    protected function buku(){
        return $this->hasMany(Buku::class, 'pengarang_id');
    }
    protected $fillable = [
        'nama',
        'alamat',
        'telp'
    ];
}
