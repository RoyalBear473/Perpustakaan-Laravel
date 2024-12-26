<?php

namespace App\Http\Controllers;

use App\Models\Pengarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pengarang::all();
        return view('content.pengarang', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form.formPengarang', ['pengarang' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|max:100',
                'alamat' => 'required|string|max:255',
                'telp' => 'required|string|max:12'
            ],
            [
                'nama.required' => 'nama harus di isi',
                'nama.string' => 'input yang di isi tidak valid',
                'nama.max' => 'karakter terlalu panjang batas:100 karakter',
                'alamat.required' => 'alamat harus di isi',
                'alamat.string' => 'input yang di isi tidak valid',
                'alamat.max' => 'karakter terlalu panjang batas:255 karakter',
                'telp.required' => 'no telefon harus di isi',
                'telp.string' => 'input yang di isi tidak valid',
                'telp.max' => 'karakter terlalu panjang batas:12 karakter',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            Pengarang::create([
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'telp' => $request->input('telp'),
            ]);
            DB::commit();
            return redirect()->route('pengarang.index')->with('success', 'Pengarang berhasil ditambahkan.');
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
        $pengarang = Pengarang::findOrFail($id);
        return view('form.formPengarang', compact('pengarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|max:100',
                'alamat' => 'required|string|max:255',
                'telp' => 'required|string|max:12'
            ],
            [
                'nama.required' => 'nama harus di isi',
                'nama.string' => 'input yang di isi tidak valid',
                'nama.max' => 'karakter terlalu panjang batas:100 karakter',
                'alamat.required' => 'alamat harus di isi',
                'alamat.string' => 'input yang di isi tidak valid',
                'alamat.max' => 'karakter terlalu panjang batas:255 karakter',
                'telp.required' => 'no telefon harus di isi',
                'telp.string' => 'input yang di isi tidak valid',
                'telp.max' => 'karakter terlalu panjang batas:12 karakter',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $pengarang = Pengarang::findOrFail($id);
            DB::beginTransaction();
            $pengarang->update([
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'telp' => $request->input('telp'),
            ]);
            DB::commit();
            return redirect()->route('pengarang.index')->with('success', 'Pengarang berhasil diupdate.');
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
        $pengarang = Pengarang::findOrFail($id);
        $pengarang->delete();
        return redirect()->route('pengarang.index')->with('success', 'Pengarang berhasil dihapus');
    }
}
