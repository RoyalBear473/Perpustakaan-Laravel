<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Penerbit::all();
        return view('content.penerbit', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form.formPenerbit', ['penerbit' => null]);
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
            Penerbit::create([
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'telp' => $request->input('telp'),
            ]);
            DB::commit();
            return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil ditambahkan.');
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
        $penerbit = Penerbit::findOrFail($id);
        return view('form.formPenerbit', compact('penerbit'));
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
            $penerbit = Penerbit::findOrFail($id);
            DB::beginTransaction();
            $penerbit->update([
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'telp' => $request->input('telp'),
            ]);
            DB::commit();
            return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil diupdate.');
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
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->delete();
        return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil dihapus');
    }
}