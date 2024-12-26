<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Petugas;
use App\Models\Rak;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Petugas::create([
            'username' => 'petugas 1',
            'password' => Hash::make('password'),
            'nama' => 'petugas 1',
            'telp' => '999999999999',
            'alamat' => 'Jakarta'
        ]);
        Anggota::create([
            'nama' => 'member 1',
            'jenis_kelamin' => 'L',
            'alamat' => 'jakarta',
            'telp' => '080808080808'
        ]);
        Pengarang::create([
            'nama' => 'pengarang 1',
            'alamat' => 'jakarta',
            'telp' => '010101010101'
        ]);
        Penerbit::create([
            'nama' => 'penerbit 1',
            'alamat' => 'jakarta',
            'telp' => '010101010101'
        ]);
        Rak::create([
            'kode_rak' => '1 001',
            'lokasi' => 'lantai 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Buku::create([
            'buku' => 'buku 1',
            'tahun_terbit' => 2000,
            'jumlah' => 5,
            'isbn' => 'ISBN 000-000-0000-00-0',
            'pengarang_id' => 1,
            'penerbit_id' => 1,
            'kode_rak' => 'rak 0001'
        ]);
    }
}
