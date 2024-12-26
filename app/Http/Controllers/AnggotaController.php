<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Anggota::all();
        return view('content.anggota', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form.formAnggota', ['anggota' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|string|max:12',
        ],[
            'nama.required' => 'Nama harus diisi.',
            'nama.string' => 'Nama tidak valid',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelamin.required' => 'Jenis kelamin harus di isi',
            'kelamin.in' => 'Jenis kelamin tidak valid',
            'alamat.required' => 'Alamat harus di isi',
            'alamat.string' => 'Alamat tidak valid',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'telp.required' => 'No telp harus di isi',
            'telp.string' => 'No telp tidak valid',
            'telp.max' => 'No telp maksimal 12 karakter.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try{
            Anggota::create([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->kelamin,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
            ]);
            return redirect()->route('anggota.index')->with('success', 'Data berhasil ditambahkan');
        }catch(\Exception $e){
            return back()->withErrors($e->getMessage());
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
        return view('form.formAnggota', ['anggota' => Anggota::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|string|max:12',
        ],[
            'nama.required' => 'Nama harus diisi.',
            'nama.string' => 'Nama tidak valid',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelamin.required' => 'Jenis kelamin harus di isi',
            'kelamin.in' => 'Jenis kelamin tidak valid',
            'alamat.required' => 'Alamat harus di isi',
            'alamat.string' => 'Alamat tidak valid',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'telp.required' => 'No telp harus di isi',
            'telp.string' => 'No telp tidak valid',
            'telp.max' => 'No telp maksimal 12 karakter.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try{
            $anggota = Anggota::findOrFail($id);
            $anggota->update([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->kelamin,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
            ]);
            return redirect()->route('anggota.index')->with('success', 'Data berhasil ditambahkan');
        }catch(\Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Data berhasil dihapus');
    }
}
