<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengembalian_detail;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalian = Pengembalian::with('anggota')
            ->with('petugas')
            ->with('peminjaman')
            ->with('pengembalian_detail.buku')
            ->get();
        return view('content.pengembalian', compact('pengembalian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjaman = Peminjaman::with('peminjaman_detail.buku')->get();
        return view('form.formPengembalian',  ['pengembalian' => null], compact('peminjaman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'peminjaman' => 'required|exists:peminjaman,id',
            'pengembalian' => 'required|date',
        ], [
            'peminjaman.required' => 'Peminjaman harus diisi.',
            'peminjaman.exists' => 'Peminjaman tidak ditemukan.',
            'pengembalian.required' => 'Tanggal pengembalian harus diisi.',
            'pengembalian.date' => 'Tanggal pengembalian tidak valid.',
        ]);

        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }

        try {
            DB::beginTransaction();

            // Ambil Data Peminjaman
            $peminjaman = Peminjaman::with('peminjaman_detail')->findOrFail($request->input('peminjaman'));

            // Hitung Denda
            $tanggal_kembali = Carbon::parse($peminjaman->tanggal_kembali);
            $tanggal_pengembalian = Carbon::parse($request->input('pengembalian'));
            $selisih_hari = $tanggal_kembali->diffInDays($tanggal_pengembalian, false);
            $denda = $selisih_hari > 0 ? $selisih_hari * 5000 : 0;
            // Simpan Data Pengembalian
            $pengembalian = Pengembalian::create([
                'tanggal_pengembalian' => $request->input('pengembalian'),
                'denda' => $denda,
                'peminjaman_id' => $peminjaman->id,
                'anggota_id' => $peminjaman->anggota_id,
                'petugas_id' => $peminjaman->petugas_id,
            ]);

            // Simpan Detail Pengembalian
            foreach ($peminjaman->peminjaman_detail as $detail) {
                Pengembalian_detail::create([
                    'pengembalian_id' => $pengembalian->id,
                    'buku_id' => $detail->buku_id,
                ]);

                // Tambahkan logika untuk menambah stok buku
                $buku = Buku::find($detail->buku_id);
                if ($buku) {
                    $buku->jumlah += 1; // Tambah stok buku
                    $buku->save();      // Simpan perubahan
                }
            }

            DB::commit();
            return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil disimpan.');
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
        $pengembalian = Pengembalian::findOrFail($id);
        $peminjaman = Peminjaman::with('peminjaman_detail.buku')->get();

        return view('form.formPengembalian', [
            'pengembalian' => $pengembalian,
            'selectedPeminjaman' => $pengembalian->peminjaman_id,
        ], compact('peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'pengembalian' => 'required|date',
        ], [
            'pengembalian.required' => 'Tanggal pengembalian harus diisi.',
            'pengembalian.date' => 'Tanggal pengembalian tidak valid.',
        ]);
    
        try {
            DB::beginTransaction();
    
            // Ambil Data Pengembalian
            $pengembalian = Pengembalian::findOrFail($id);
    
            // Ambil Data Peminjaman
            $peminjaman = Peminjaman::with('peminjaman_detail')->findOrFail($request->input('peminjaman'));
    
            // Hitung Denda
            $tanggal_kembali = Carbon::parse($peminjaman->tanggal_kembali);
            $tanggal_pengembalian = Carbon::parse($request->input('pengembalian'));
            $selisih_hari = $tanggal_kembali->diffInDays($tanggal_pengembalian);
            $denda = $selisih_hari > 0 ? $selisih_hari * 5000 : 0;
    
            // Update Data Pengembalian
            $pengembalian->update([
                'tanggal_pengembalian' => $request->input('pengembalian'),
                'denda' => $denda,
                'peminjaman_id' => $peminjaman->id,
                'anggota_id' => $peminjaman->anggota_id,
                'petugas_id' => $peminjaman->petugas_id,
            ]);
    
            DB::commit();
            return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui.');
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
        $pengembalian = Pengembalian::findOrFail($id);
        $detail = Pengembalian_detail::where('pengembalian_id', $pengembalian->id)->first();
        $book = $detail->buku_id;
        Buku::where('id', $book)->decrement('jumlah');
        $detail->delete();
        $pengembalian->delete();
        return redirect()->route('pengembalian.index')->with('success', 'peminjaman berhasil dihapus');
    }
}
