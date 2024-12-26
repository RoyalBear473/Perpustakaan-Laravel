<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $primaryKey = 'kode_rak';
    public $incrementing = false;
    protected $keyType = 'string';
    use HasFactory;
    protected function buku(){
        return $this->hasMany(Buku::class, 'kode_rak');
    }
    protected $fillable = [
        'kode_rak',
        'lokasi'
    ];
}
