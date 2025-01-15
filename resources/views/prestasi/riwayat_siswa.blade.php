@extends('layouts.main')
@section('container')

    <h4><b>Riwayat Prestasi</b></h4>
    
    <div class="card">
        <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 20px;">
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck">
                                <label class="form-check-label" for="ordercheck"></label>
                            </div>
                        </th>
                        <th>Jenis Kompetisi</th>
                        <th>Juara</th>
                        <th>Tingkat</th>
                        <th>Poin</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Oleh</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($riwayat_prestasi as $siswa)
                    <tr>
                        <td>
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck{{ $siswa->id }}">
                                <label class="form-check-label" for="ordercheck"></label>
                            </div>
                        </td>
                        <td>{{ $siswa->kompetisi }}</td>
                        <td>{{ $siswa->juara }}</td>
                        <td>{{ $siswa->tingkat }}</td>
                        <td>{{ $siswa->poin }}</td>
                        <td>{{ $siswa->keterangan }}</td>
                        <td>{{ $siswa->created_at->format('Y-m-d') }}</td>
                        <td>{{ $siswa->created_by }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection