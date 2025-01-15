<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggarans = Pelanggaran::all();
    
        return view('pelanggaran.index', ['pelanggarans' => $pelanggarans]);
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
        $validatedData = $request->only(['item', 'poin', 'kategori']);
    
        if (auth()->check()) {
            $user = auth()->user();
            $validatedData['user_id'] = $user->id;
    
            Pelanggaran::create($validatedData);
    
            return redirect('/pelanggaran')->with('success', 'Data Pelanggaran Berhasil Ditambahkan');
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Menambahkan Data Pelanggaran');
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
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validatedData = $request->only(['item', 'poin','kategori']);

        Pelanggaran::where('id', $pelanggaran->id)
            ->update($validatedData);
        
        return redirect('/pelanggaran')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggaran $pelanggaran)
    {
        Pelanggaran::destroy($pelanggaran->id);
        return redirect('/pelanggaran')->with('success', 'Data Pelanggaran Berhasil Dihapus');
    }
}
