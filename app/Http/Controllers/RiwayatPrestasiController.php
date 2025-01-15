<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Prestasi;
use App\Models\RiwayatPrestasi;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatPrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_siswa', true)->get();
        $kelass = Kelas::all();
        $prestasis = Prestasi::all();
    
        return view('prestasi.create', ['users' => $users, 'kelass' => $kelass, 'prestasis' => $prestasis]);
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
         if (auth()->check()) {
             $validatedData = $request->only(['nama', 'nisn', 'kelas', 'angkatan', 'kompetisi', 'juara','tingkat', 'poin','keterangan','created_at']);
 
             $validatedData['created_by'] = auth()->user()->name;
 
             RiwayatPrestasi::create($validatedData);
             $user = User::where('nips', $validatedData['nisn'])->first();
     
             if ($user) {
                 $user->poin_prestasi += $validatedData['poin'];
                 $user->save();
             }
             return redirect('/riwayat-prestasi')->with('success', 'Data Prestasi Berhasil Ditambahkan');
         } else {
             return redirect('/')->with('error', 'Mohon Login Untuk Menambahkan Data Prestasi');
         }
     }
    public function riwayatSiswa()
    {
        if (auth()->check()) {
            $userName = auth()->user()->name;
    
            $riwayat = RiwayatPrestasi::where('nama', $userName)->get();
    
            return view('prestasi.riwayat_siswa', ['riwayat_prestasi' => $riwayat]);
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Melihat Riwayat Prestasi Siswa');
        }
    } 
    public function riwayatGuru()
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->is_admin) {
                // Jika pengguna adalah admin, ambil semua data
                $riwayat = RiwayatPrestasi::all();
            } else {
                // Jika pengguna bukan admin, ambil data berdasarkan nama pengguna
                $userName = $user->name;
                $riwayat = RiwayatPrestasi::where('created_by', $userName)->get();
            }
            
            return view('prestasi.riwayat_guru', ['riwayat_prestasi' => $riwayat]);
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Melihat Riwayat Pelanggaran Siswa');
        }
    }
    
    public function prestasiSiswa()
    {
        $users = User::where('is_siswa', true)->get();
    
        return view('prestasi.prestasi_siswa', ['users' => $users]);
    } 
    /**
     * Display the specified resource.
     */
    public function show($nips)
    {
        $siswaDetail = User::where('nips', $nips)->first();
        // dd($siswaDetail);
        if (!$siswaDetail) {
            return redirect('/')->with('error', 'Siswa tidak ditemukan');
        }
    
        $riwayat = RiwayatPrestasi::where('nisn', $siswaDetail->nips)->get();
    
        return view('prestasi.prestasi_siswa_detail', ['siswaDetail' => $siswaDetail, 'riwayat_prestasi' => $riwayat]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapusDetail($nips, $id)
    {
        // Find the prestasi by id
        $prestasi = RiwayatPrestasi::find($id);
        $siswa = User::where('nips', $nips)->first();

        if (!$prestasi) {
            return redirect()->back()->with('error', 'Pelanggaran tidak ditemukan.');
        }

        if (!$siswa) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }

        // Kurangi poin prestasi siswa
        $siswa->poin_prestasi -= $prestasi->poin;
        $siswa->save();

        // Delete the prestasi
        $prestasi->delete();

        return redirect()->back()->with('success', 'Pelanggaran berhasil dihapus.');
    }
}
