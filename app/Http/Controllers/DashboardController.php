<?php

namespace App\Http\Controllers;

use App\Charts\GrafikRiwayatChart;
use App\Models\RiwayatPelanggaran;
use App\Models\RiwayatPrestasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(GrafikRiwayatChart $chart)
    {
        $totalAdmin = User::where('is_admin', true)->count();
        $totalGuru  = User::where('is_guru', true)->count();
        $totalSiswa = User::where('is_siswa', true)->count();
        $totalPrestasi = RiwayatPrestasi::all()->count();
        $totalPelanggaran = RiwayatPelanggaran::all()->count();

        //admin
        // Build the chart and assign it to a variable
        $chartData = $chart->build();
        $topPrestasi = User::where('is_siswa', true)
        ->orderBy('poin_prestasi', 'desc')
        ->take(5)
        ->get();

        $riwayatPrestasi = RiwayatPrestasi::orderBy('created_at', 'desc')->get()->map(function($item) {
            $item->jenis = 'prestasi';
            return $item;
        });
        
        $riwayatPelanggaran = RiwayatPelanggaran::orderBy('created_at', 'desc')->get()->map(function($item) {
            $item->jenis = 'pelanggaran';
            return $item;
        });
        
        // Gabungkan koleksi dan urutkan berdasarkan created_at
        $combined = $riwayatPrestasi->merge($riwayatPelanggaran)->sortByDesc('created_at');

        //guru
        $userName = Auth::user()->name;

        $totalInputPrestasi = RiwayatPrestasi::where('created_by', $userName)->count();
        $totalInputPelanggaran = RiwayatPelanggaran::where('created_by', $userName)->count();

        $riwayatInputPrestasi = RiwayatPrestasi::where('created_by', $userName)->orderBy('created_at', 'desc')->get()->map(function($item) {
            $item->jenis = 'prestasi';
            return $item;
        });
        
        $riwayatInputPelanggaran = RiwayatPelanggaran::where('created_by', $userName)->orderBy('created_at', 'desc')->get()->map(function($item) {
            $item->jenis = 'pelanggaran';
            return $item;
        });
        
        // Gabungkan koleksi dan urutkan berdasarkan created_at
        $combinedInput = $riwayatInputPrestasi->merge($riwayatInputPelanggaran)->sortByDesc('created_at');

        //siswa
        $totalPrestasiSiswa = RiwayatPrestasi::where('nama', $userName)->count();
        $totalPelanggaranSiswa = RiwayatPelanggaran::where('nama', $userName)->count();

        $totalPoin = User::where('name', $userName)->get();

        $riwayatPrestasiSiswa = RiwayatPrestasi::where('nama', $userName)->orderBy('created_at', 'desc')->get()->map(function($item) {
            $item->jenis = 'prestasi';
            return $item;
        });
        
        $riwayatPelanggaranSiswa = RiwayatPelanggaran::where('nama', $userName)->orderBy('created_at', 'desc')->get()->map(function($item) {
            $item->jenis = 'pelanggaran';
            return $item;
        });
        
        // Gabungkan koleksi dan urutkan berdasarkan created_at
        $combinedInputSiswa = $riwayatPrestasiSiswa->merge($riwayatPelanggaranSiswa)->sortByDesc('created_at');
        return view('dashboard.index', compact(
            'totalAdmin',
            'totalGuru',
            'totalSiswa',
            'totalPrestasi',
            'totalPelanggaran',
            'chartData', // Include chartData as a variable
            'topPrestasi',
            'riwayatPrestasi',
            'combined',
            'totalInputPrestasi',
            'totalInputPelanggaran',
            'combinedInput',
            'totalPrestasiSiswa',
            'totalPelanggaranSiswa',
            'totalPoin',
            'combinedInputSiswa',
        ));
    }
}
