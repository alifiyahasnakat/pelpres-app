@extends('layouts.main')
@section('container')
<h4><b>Kelola Data Kelas</b></h4>

<div class="card">
    <div class="card-body">
        <a href="" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target=".tambah">
            <i class="fas fa-user-plus me-1"></i>Tambah Data Kelas
        </a>
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
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($kelass as $kelas)
                    <tr>
                        <td>
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck{{ $kelas->id }}">
                                <label class="form-check-label" for="ordercheck{{ $kelas->id }}"></label>
                            </div>
                        </td>
                        <td>{{ $kelas->nama }}</td>
                        <td class="d-flex align-items-center justify-content-center">
                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn p-0 mx-3 text-danger deleteBtn" type="submit">
                                    <i class="uil uil-trash-alt font-size-18"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade tambah" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('kelas.store') }}">
                    @csrf
                    <div class="row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Nama Kelas</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Masukkan Nama Kelas" name="nama" id="nama" required>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <div class="d-flex flex-wrap gap-3">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
                                <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
