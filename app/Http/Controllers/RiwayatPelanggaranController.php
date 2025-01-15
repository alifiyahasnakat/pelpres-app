<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatPelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pelanggaran.create',[
            'users' => User::where('is_siswa', true)->get(),
            'pelanggarans' => Pelanggaran::all(),
            'kelass' => Kelas::all()
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function riwayatSiswa()
    {
        if (auth()->check()) {
            $userName = auth()->user()->name;
    
            $riwayat = RiwayatPelanggaran::where('nama', $userName)->get();
    
            return view('pelanggaran.riwayat_siswa', ['riwayat_pelanggaran' => $riwayat]);
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Melihat Riwayat Pelanggaran Siswa');
        }
    }     
    
    public function riwayatGuru()
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->is_admin) {
                // Jika pengguna adalah admin, ambil semua data
                $riwayat = RiwayatPelanggaran::all();
            } else {
                // Jika pengguna bukan admin, ambil data berdasarkan nama pengguna
                $userName = $user->name;
                $riwayat = RiwayatPelanggaran::where('created_by', $userName)->get();
            }
            
            return view('pelanggaran.riwayat_guru', ['riwayat_pelanggaran' => $riwayat]);
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Melihat Riwayat Pelanggaran Siswa');
        }
    }
    
    public function pelanggaranSiswa()
    {
        $users = User::where('is_siswa', true)->get();
    
        return view('pelanggaran.pelanggaran_siswa', ['users' => $users]);
    }

    public function pelanggaranSiswaDetail()
    {
        $riwayat = RiwayatPelanggaran::all();
    
        return view('pelanggaran.pelanggaran_siswa_detail', ['riwayat_pelanggaran' => $riwayat]);
    } 

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->check()) {
            $validatedData = $request->only(['nama', 'nisn', 'kelas', 'angkatan', 'jenis', 'kategori', 'poin','keterangan','created_at']);
    
            $validatedData['created_by'] = auth()->user()->name;
    
            RiwayatPelanggaran::create($validatedData);
    
            $user = User::where('nips', $validatedData['nisn'])->first();
    
            if ($user) {
                $user->poin_pelanggaran += $validatedData['poin'];
                $user->save();
            }
    
            return redirect('/riwayat-pelanggaran')->with('success', 'Data Pelanggaran Berhasil Ditambahkan');
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Menambahkan Data Pelanggaran');
        }
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
    
        $riwayat = RiwayatPelanggaran::where('nisn', $siswaDetail->nips)->get();
    
        return view('pelanggaran.pelanggaran_siswa_detail', ['siswaDetail' => $siswaDetail, 'riwayat_pelanggaran' => $riwayat]);
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
        // Find the pelanggaran by id
        $pelanggaran = RiwayatPelanggaran::find($id);
        $siswa = User::where('nips', $nips)->first();

        if (!$pelanggaran) {
            return redirect()->back()->with('error', 'Pelanggaran tidak ditemukan.');
        }

        if (!$siswa) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }

        // Kurangi poin pelanggaran siswa
        $siswa->poin_pelanggaran -= $pelanggaran->poin;
        $siswa->save();

        // Delete the pelanggaran
        $pelanggaran->delete();

        return redirect()->back()->with('success', 'Pelanggaran berhasil dihapus.');
    }
}
