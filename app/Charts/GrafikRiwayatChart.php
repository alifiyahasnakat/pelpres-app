<?php

namespace App\Charts;

use App\Models\RiwayatPelanggaran;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\RiwayatPrestasi;
use Illuminate\Support\Facades\DB;

class GrafikRiwayatChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $currentYear = date('Y');

        // Ambil data Riwayat Prestasi per bulan untuk tahun berjalan
        $prestasiData = RiwayatPrestasi::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Ambil data Riwayat Pelanggaran per bulan untuk tahun berjalan
        $pelanggaranData = RiwayatPelanggaran::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        
        // Inisialisasi data per bulan untuk prestasi dan pelanggaran
        $prestasiCounts = array_fill(0, 12, 0);
        $pelanggaranCounts = array_fill(0, 12, 0);

        // Isi data prestasi ke array berdasarkan bulan
        foreach ($prestasiData as $month => $count) {
            $prestasiCounts[$month - 1] = $count;
        }

        // Isi data pelanggaran ke array berdasarkan bulan
        foreach ($pelanggaranData as $month => $count) {
            $pelanggaranCounts[$month - 1] = $count;
        }

        // Buat grafik dengan dua set data
        return $this->chart->barChart()
            ->setTitle($currentYear)
            ->addData('Prestasi', $prestasiCounts)
            ->addData('Pelanggaran', $pelanggaranCounts)
            ->setXAxis($months);
    }
}