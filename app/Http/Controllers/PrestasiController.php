<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $individus = Prestasi::where('kompetisi','Kompetisi Individu')->get();
        $kelompoks = Prestasi::where('kompetisi','Kompetisi Kelompok')->get();
        return view('prestasi.index', compact('individus','kelompoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kompetisi' => 'required|string|max:255',
            'juara' => 'required|string|max:255',
            'sekolah' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'nasional' => 'required',
            'internasional' => 'required',
        ]);
        if (auth()->check()) {
            $user = auth()->user();
            $validatedData['user_id'] = $user->id;
    
            Prestasi::create($validatedData);
    
            return redirect('/prestasi')->with('success', 'Data Prestasi Berhasil Ditambahkan');
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Menambahkan Data Prestasi');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'juara' => 'required|string|max:255',
            'sekolah' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',
            'nasional' => 'required',
            'internasional' => 'required',
        ]);

        Prestasi::where('id', $id)->update($validatedData);

        return redirect('/prestasi')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
    {
        // Temukan data prestasi berdasarkan ID
        $prestasi = Prestasi::findOrFail($id);

        // Hapus data prestasi
        $prestasi->delete();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data prestasi berhasil dihapus');
    }
}
