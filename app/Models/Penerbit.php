<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    use HasFactory;
    protected function buku(){
        return $this->hasMany(Buku::class, 'penerbit_id');
    }
    protected $fillable = [
        'nama',
        'alamat',
        'telp'
    ];
}
