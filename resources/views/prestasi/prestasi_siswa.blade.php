@extends('layouts.main')
@section('container')

    <h4><b>Prestasi Siswa</b></h4>
    
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
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Angkatan</th>
                        <th>Poin Prestasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $siswa)
                    <tr>
                        <td>
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck{{ $siswa->id }}">
                                <label class="form-check-label" for="ordercheck"></label>
                            </div>
                        </td>
                        <td>{{ $siswa->nips }}</td>
                        <td>{{ $siswa->name }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>{{ $siswa->angkatan }}</td>
                        <td>{{ $siswa->poin_prestasi }}</td>
                        <td class="d-flex align-items-center justify-content-center">
                            <a href="/detail-prestasi-siswa/{{ $siswa->nips }}" class="btn p-0 mx-3 text-primary edit-user" data-toggle="tooltip" data-placement="top" title="Detail Pelanggaran">
                                <i class="uil uil-eye font-size-18"></i>
                            </a>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection