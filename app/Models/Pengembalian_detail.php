<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengembalian_id',
        'buku_id',
    ];

    public function pengembalian(){
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id');
    }
    public function buku(){
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
