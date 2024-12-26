<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rak = Rak::all();
        return view('content.rak', compact('rak'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form.formRak', ['rak' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode' => 'required|string|max:10',
                'lokasi' => 'required|string|max:255'
            ],
            [
                'kode.required' => 'kode rak harus di isi',
                'kode.string' => 'input yang di isi t   idak valid',
                'kode.max' => 'karakter terlalu panjang batas:100 karakter',
                'lokasi.required' => 'lokasi harus di isi',
                'lokasi.string' => 'input yang di isi tidak valid',
                'lokasi.max' => 'karakter terlalu panjang batas:255 karakter',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            Rak::create([
                'kode_rak' => $request->input('kode'),
                'lokasi' => $request->input('lokasi')
            ]);
            DB::commit();
            return redirect()->route('rak.index')->with('success', 'rak berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kode_rak)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $kode_rak)
    {
        $rak = Rak::findOrFail($kode_rak);
        return view('form.formRak', compact('rak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kode_rak)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode' => 'required|string|max:10',
                'lokasi' => 'required|string|max:255'
            ],
            [
                'kode.required' => 'kode rak harus di isi',
                'kode.string' => 'input yang di isi t   idak valid',
                'kode.max' => 'karakter terlalu panjang batas:100 karakter',
                'lokasi.required' => 'lokasi harus di isi',
                'lokasi.string' => 'input yang di isi tidak valid',
                'lokasi.max' => 'karakter terlalu panjang batas:255 karakter',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $rak = Rak::findOrFail($kode_rak);
            DB::beginTransaction();
            $rak->update([
                'kode_rak' => $request->input('kode'),
                'lokasi' => $request->input('lokasi')
            ]);
            DB::commit();
            return redirect()->route('rak.index')->with('success', 'rak berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kode_rak)
    {
        $rak = Rak::findOrFail($kode_rak);
        $rak->delete();
        return redirect()->route('rak.index')->with('success', 'rak berhasil dihapus');
    }
}
