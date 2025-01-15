@extends('layouts.main')
@section('container')
@can('superAdmin')
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="total-revenue-chart">
                        <i class="uil-users-alt" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalAdmin }}</span></h2>
                    <p class="text-muted mb-0">Total Admin</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="orders-chart">
                        <i class="uil-users-alt" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalGuru }}</span></h2>
                    <p class="text-muted mb-0">Total Guru</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="customers-chart">
                        <i class="uil-users-alt" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalSiswa }}</span></h2>
                    <p class="text-muted mb-0">Total Siswa</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->
@endcan
@can('admin')
<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="total-revenue-chart">
                        <i class="uil-medal" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalPrestasi }}</span></h2>
                    <p class="text-muted mb-0">Total Prestasi</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="orders-chart">
                        <i class="uil-exclamation-octagon" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalPelanggaran }}</span></h2>
                    <p class="text-muted mb-0">Total Pelanggaran</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

</div> <!-- end row-->

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Grafik Prestasi & Pelanggaran</h4>

                <div class="mt-3">
                    {!! $chartData->container() !!}
                    <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-4">


        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Top Siswa Berprestasi</h4>
                @foreach ($topPrestasi as $siswa)
                <div class="progress-container">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <p class="student-name mb-1">
                                <i class="mdi mdi-circle-medium text-primary me-2"></i> 
                                {{ $siswa->name }}
                            </p>
                        </div>
                        <div class="col-sm-7">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $siswa->poin_prestasi / 100 * 100 }}%" aria-valuenow="{{ $siswa->poin_prestasi }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <small class="text-muted">{{ $siswa->poin_prestasi }} Poin</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> <!-- end card-body-->
        </div> <!-- end card-->
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Aktifitas Terbaru</h4>

                <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 336px;">
                    @foreach ($combined as $activity)
                    <li class="feed-item">
                        <div class="feed-item-list">
                            <p class="text-muted mb-1 font-size-13">
                                {{ $activity->created_at->format('d M, Y') }}
                                <small class="d-inline-block ms-1">{{ $activity->created_at->format('h:i a') }}</small>
                            </p>
                            <p class="mt-0 mb-0">
                                {{ $activity->created_by }} 
                                @if(isset($activity->jenis) && $activity->jenis == 'prestasi')
                                Menambahkan <span class="text-success">{{ $activity->poin }}</span> Poin Prestasi
                                @else
                                Menambahkan <span class="text-danger">{{ $activity->poin }}</span> Poin Pelanggaran 
                                @endif
                                
                                Kepada: <span class="text-primary">{{ $activity->nama }}</span>
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div> <!-- end Col -->
</div> <!-- end row-->
@endcan
@can('guru')
<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="total-revenue-chart">
                        <i class="uil-medal" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalInputPrestasi }}</span></h2>
                    <p class="text-muted mb-0">Riwayat Input Prestasi</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="orders-chart">
                        <i class="uil-exclamation-octagon" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalInputPelanggaran }}</span></h2>
                    <p class="text-muted mb-0">Riwayat Input Pelanggaran</p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->

<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Aktifitas Terbaru</h4>

                <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 336px;">
                    @foreach ($combinedInput as $activity)
                    <li class="feed-item">
                        <div class="feed-item-list">
                            <p class="text-muted mb-1 font-size-13">
                                {{ $activity->created_at->format('d M, Y') }}
                                <small class="d-inline-block ms-1">{{ $activity->created_at->format('h:i a') }}</small>
                            </p>
                            <p class="mt-0 mb-0">
                                @if(isset($activity->jenis) && $activity->jenis == 'prestasi')
                                Menambahkan <span class="text-success">{{ $activity->poin }}</span> Poin Prestasi
                                @else
                                Menambahkan <span class="text-danger">{{ $activity->poin }}</span> Poin Pelanggaran 
                                @endif
                                
                                Kepada: <span class="text-primary">{{ $activity->nama }}</span>
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div> <!-- end row-->
@endcan
@can('siswa')
<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="total-revenue-chart">
                        <i class="uil-medal" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalPrestasiSiswa }}</span></h2>
                    <p class="text-muted mb-0">Total Prestasi</p>
                    <p>
                        <span class="text-success me-1">
                            @foreach ($totalPoin as $poin)
                            <i class="mdi mdi-arrow-up-bold me-1"></i>{{ $poin->poin_prestasi }} Poin
                            @endforeach
                        </span> 
                    </p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="card-body">
                <div class="float-end mt-2">
                    <div id="orders-chart">
                        <i class="uil-exclamation-octagon" style="font-size: 50px;"></i>
                    </div>
                </div>
                <div>
                    <h2 class="mb-1 mt-1"><span data-plugin="counterup">{{ $totalPelanggaranSiswa }}</span></h2>
                    <p class="text-muted mb-0">Total Pelanggaran</p>
                    <p> 
                        <span class="text-danger me-1">
                        @foreach ($totalPoin as $poin)
                            <i class="mdi mdi-arrow-up-bold me-1"></i>{{ $poin->poin_pelanggaran }} Poin
                        @endforeach
                        </span> 
                    </p>
                </div>
            </div>
        </div>
    </div> <!-- end col-->
</div> <!-- end row-->
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Aktifitas Terbaru</h4>

                <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 336px;">
                    @foreach ($combinedInputSiswa as $activity)
                    <li class="feed-item">
                        <div class="feed-item-list">
                            <p class="text-muted mb-1 font-size-13">
                                {{ $activity->created_at->format('d M, Y') }}
                                <small class="d-inline-block ms-1">{{ $activity->created_at->format('h:i a') }}</small>
                            </p>
                            <p class="mt-0 mb-0">
                                <span class="text-primary">{{ $activity->created_by }}</span> 
                                @if(isset($activity->jenis) && $activity->jenis == 'prestasi')
                                Menambahkan <span class="text-success">{{ $activity->poin }}</span> Poin Prestasi
                                @else
                                Menambahkan <span class="text-danger">{{ $activity->poin }}</span> Poin Pelanggaran 
                                @endif
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div> <!-- end row-->
@endcan
<script src="{{ $chartData->cdn() }}"></script>

{{ $chartData->script() }}
@endsection