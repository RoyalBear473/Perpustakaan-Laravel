<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use App\Models\Pengarang;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::with('pengarang')
            ->with('penerbit')
            ->with('rak')
            ->get();
        return view('content.buku', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengarang = Pengarang::all();
        $penerbit = Penerbit::all();
        $rak = Rak::all();
        return view('form.formBuku',  ['buku' => null], compact(['pengarang', 'penerbit', 'rak']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'buku' => 'required|string|max:100',
                'tahun' => 'required|integer',
                'jumlah' => 'required|integer',
                'isbn' => 'required|string|max:45',
                'rak' => 'required|exists:raks,kode_rak',
                'pengarang' => 'required|exists:pengarangs,id',
                'penerbit' => 'required|exists:penerbits,id'
            ],
            [
                'buku.required' => 'Nama buku harus diisi.',
                'buku.string' => 'Nama buku harus berupa teks.',
                'buku.max' => 'Nama buku tidak boleh lebih dari 100 karakter.',
                'tahun.required' => 'Tahun terbit harus diisi.',
                'tahun.integer' => 'Tahun terbit harus berupa angka.',
                'jumlah.required' => 'Jumlah buku harus diisi.',
                'jumlah.integer' => 'Jumlah buku harus berupa angka.',
                'isbn.required' => 'ISBN harus diisi.',
                'isbn.string' => 'ISBN harus berupa teks.',
                'isbn.max' => 'ISBN tidak boleh lebih dari 45 karakter.',
                'rak.required' => 'Kode rak harus diisi.',
                'rak.exists' => 'Kode rak tidak ditemukan.',
                'pengarang.required' => 'Pengarang harus dipilih.',
                'pengarang.exists' => 'Pengarang tidak valid.',
                'penerbit.required' => 'Penerbit harus dipilih.',
                'penerbit.exists' => 'Penerbit tidak valid.',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            Buku::create([
                'buku' => $request->input('buku'),
                'tahun_terbit' => $request->input('tahun'),
                'jumlah' => $request->input('jumlah'),
                'isbn' => $request->input('isbn'),
                'kode_rak' => $request->input('rak'),
                'penerbit_id' => $request->input('penerbit'),
                'pengarang_id' => $request->input('pengarang'),
            ]);
            DB::commit();
            return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($validator)->withInput();
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
        $buku = Buku::with(['rak', 'pengarang', 'penerbit'])->findOrFail($id);
        $pengarang = Pengarang::all();
        $penerbit = Penerbit::all();
        $rak = Rak::all();
        return view('form.formBuku', compact('buku', 'pengarang', 'penerbit', 'rak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'buku' => 'required|string|max:100',
                'tahun' => 'required|integer',
                'jumlah' => 'required|integer',
                'isbn' => 'required|string|max:45',
                'rak' => 'required|exists:raks,kode_rak',
                'pengarang' => 'required|exists:pengarangs,id',
                'penerbit' => 'required|exists:penerbits,id'
            ],
            [
                'buku.required' => 'Nama buku harus diisi.',
                'buku.string' => 'Nama buku harus berupa teks.',
                'buku.max' => 'Nama buku tidak boleh lebih dari 100 karakter.',
                'tahun.required' => 'Tahun terbit harus diisi.',
                'tahun.integer' => 'Tahun terbit harus berupa angka.',
                'jumlah.required' => 'Jumlah buku harus diisi.',
                'jumlah.integer' => 'Jumlah buku harus berupa angka.',
                'isbn.required' => 'ISBN harus diisi.',
                'isbn.string' => 'ISBN harus berupa teks.',
                'isbn.max' => 'ISBN tidak boleh lebih dari 45 karakter.',
                'rak.required' => 'Kode rak harus diisi.',
                'rak.exists' => 'Kode rak tidak ditemukan.',
                'pengarang.required' => 'Pengarang harus dipilih.',
                'pengarang.exists' => 'Pengarang tidak valid.',
                'penerbit.required' => 'Penerbit harus dipilih.',
                'penerbit.exists' => 'Penerbit tidak valid.',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $buku = Buku::findOrFail($id);
            $buku->update([
                'buku' => $request->input('buku'),
                'tahun_terbit' => $request->input('tahun'),
                'jumlah' => $request->input('jumlah'),
                'isbn' => $request->input('isbn'),
                'kode_rak' => $request->input('rak'),
                'penerbit_id' => $request->input('penerbit'),
                'pengarang_id' => $request->input('pengarang'),
            ]);
            return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors($validator)->withInput();;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::with(['rak', 'pengarang', 'penerbit'])->findOrFail($id);
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
