@extends('layouts.main')
@section('container')

    <h4><b>Riwayat Pelanggaran</b></h4>
    
    <div class="card">
        <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <thead>
                    <tr>
                        <th style="width: 20px;">
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck">
                                <label class="form-check-label" for="ordercheck"></label>
                            </div>
                        </th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Oleh</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($riwayat_pelanggaran as $siswa)
                    <tr>
                        <td>
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck{{ $siswa->id }}">
                                <label class="form-check-label" for="ordercheck"></label>
                            </div>
                        </td>
                        <td>{{ $siswa->jenis }}</td>
                        <td>{{ $siswa->poin }}</td>
                        <td>{{ $siswa->kategori }}</td>
                        <td>{{ $siswa->keterangan }}</td>
                        <td>{{ $siswa->created_at }}</td>
                        <td>{{ $siswa->created_by }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection