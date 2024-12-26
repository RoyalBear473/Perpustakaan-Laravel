<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Peminjaman_detail;
use App\Models\Pengembalian;
use App\Models\Pengembalian_detail;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with('anggota')
            ->with('petugas')
            ->with('peminjaman_detail.buku')
            ->get();
        return view('content.peminjaman', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $petugas = Petugas::all();
        $anggota = Anggota::all();
        $buku = Buku::where('jumlah', '>', 0)->get();
        return view('form.formPeminjaman',  ['peminjaman' => null], compact('petugas', 'anggota', 'buku'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'pinjam' => 'required|date',
            'kembali' => 'required|date|after_or_equal:pinjam',
            'anggota' => 'required|exists:anggotas,id',
            'petugas' => 'required|exists:petugas,id',
            'buku' => 'required|exists:bukus,id',
        ], [
            'pinjam.required' => 'Tanggal Pinjam pinjam wajib diisi',
            'kembali.required' => 'Tanggal Kembali wajib diisi',
            'anggota.required' => 'Anggota wajib diisi',
            'petugas.required' => 'Petugas wajib diisi',
            'buku.required' => 'Buku wajib diisi',
            'kembali.after_or_equal' => 'Tanggal Kembali harus setelah atau sama dengan Tanggal Pinjam',
            'anggota.exists' => 'Anggota tidak ditemukan',
            'petugas.exists' => 'Petugas tidak ditemukan',
            'buku.exists' => 'Buku tidak ditemukan',
            'pinjam.date' => 'Tanggal Pinjam tidak valid',
            'kembali.date' => 'Tanggal Kembali tidak valid',
        ]);
        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }
        try {
            DB::beginTransaction();
            $buku = Buku::findOrFail($request->input('buku'));
            if ($buku->jumlah <= 0) {
                return back()->withErrors(['buku' => 'Stok buku tidak mencukupi'])->withInput();
            }
            $buku->jumlah -= 1;
            $buku->save();
            $peminjaman = Peminjaman::create([
                'tanggal_pinjam' => $request->input('pinjam'),
                'tanggal_kembali' => $request->input('kembali'),
                'anggota_id' => $request->anggota,
                'petugas_id' => $request->petugas
            ]);
            Peminjaman_detail::create([
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $request->input('buku')
            ]);
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $petugas = Petugas::all();
        $anggota = Anggota::all();
        $peminjaman = Peminjaman::findOrFail($id);
        $detail = Peminjaman_detail::where('peminjaman_id', $peminjaman->id)->first();
        $selectedBook = $detail ? $detail->buku_id : null;
        if ($selectedBook) {
            $buku = Buku::where('jumlah', '>', 0)
                ->orWhere('id', $selectedBook) // Tambahkan buku yang sudah dipilih sebelumnya
                ->get();
        } else {
            $buku = Buku::where('jumlah', '>', 0)->get();
        }
        return view('form.formPeminjaman', compact('petugas', 'anggota', 'buku', 'peminjaman', 'selectedBook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'pinjam' => 'required|date',
            'kembali' => 'required|date|after_or_equal:pinjam',
            'anggota' => 'required|exists:anggotas,id',
            'petugas' => 'required|exists:petugas,id',
            'buku' => 'required|exists:petugas,id',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $peminjaman = Peminjaman::findOrFail($id);
            $detail = Peminjaman_detail::where('peminjaman_id', $peminjaman->id)->first();
            $oldBookId = $detail->buku_id;

            $peminjaman->update([
                'tanggal_pinjam' => $request->input('pinjam'),
                'tanggal_kembali' => $request->input('kembali'),
                'anggota_id' => $request->anggota,
                'petugas_id' => $request->petugas
            ]);
            if ($oldBookId != $request->buku) {
                Buku::where('id', $oldBookId)->increment('jumlah');
                Buku::where('id', $request->buku)->decrement('jumlah');
            }
            $detail->update([
                'buku_id' => $request->buku,
            ]);
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil di update.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $detail = Peminjaman_detail::where('peminjaman_id', $peminjaman->id)->first();
        $kembali = Pengembalian::where('peminjaman_id', $peminjaman->id)->first();
        if ($kembali) {
            $pengembalian = Pengembalian_detail::where('pengembalian_id', $kembali->id)->first();
            $pengembalian->delete();
            $kembali->delete();
        }else{
            $book = $detail->buku_id;
            Buku::where('id', $book)->increment('jumlah');
        }
        $detail->delete();
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'peminjaman berhasil dihapus');
    }
}
