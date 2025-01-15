<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class PindahNaikKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('data.pindah-naik.index',[
            'users' => User::where('is_siswa', true)->get(),
            'kelass' => Kelas::all()
        ]);
    }
    public function getSiswaByKelas($kelas)
    {
        $siswa = User::where('kelas', $kelas)->get();
    
        return response()->json($siswa);
    }

    public function update(Request $request)
    {
        $siswaIds = $request->input('siswa_ids');
        $kelasTujuan = $request->input('kelas_tujuan');

        if (!$siswaIds || !$kelasTujuan) {
            return redirect()->back()->with('error', 'Pilih siswa dan kelas tujuan terlebih dahulu.');
        }

        if ($kelasTujuan == 'Alumni') {
            User::whereIn('id', $siswaIds)->update([
                'kelas' => $kelasTujuan,
                'is_siswa' => false,
                'is_alumni' => true
            ]);
        } else {
            User::whereIn('id', $siswaIds)->update(['kelas' => $kelasTujuan]);
        }

        return redirect()->route('pindah-naik.index')->with('success', 'Siswa berhasil dipindahkan ke kelas baru.');
    }
    // Methods lainnya...
    
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
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
