@extends('layouts.main')
@section('container')
<h4><b>Kelola Data Admin</b></h4>

<div class="card">
    <div class="card-body">
        <a href="" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target=".tambah">
            <i class="fas fa-user-plus me-1"
            ></i>Tambah Data Admin
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
                        <th>Kode Admin</th>
                        <th>Nama</th>
                        <th>Kata Sandi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $admin)
                    <tr>
                        <td>
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck{{ $admin->id }}">
                                <label class="form-check-label" for="ordercheck"></label>
                            </div>
                        </td>
                        <td>{{ $admin->nips }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->password }}</td>
                        <td class="d-flex align-items-center justify-content-center">
                            <a class="btn p-0 mx-3 text-primary edit-user" data-bs-toggle="modal" data-bs-target=".modalEdit"
                                data-admin-id="{{ $admin->id }}" 
                                data-admin-name="{{ $admin->name }}" 
                                data-admin-nips="{{ $admin->nips }}"
                            >
                                <i class="uil uil-pen font-size-18"></i>
                            </a>

                            <form action="/admin/{{ $admin->id }}" method="post" id="deleteForm_{{ $admin->id }}">
                                @method('delete')
                                @csrf
                                <button class="btn p-0 mx-3 text-danger deleteBtn" type="button">
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.deleteBtn');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const adminId = this.closest('form').getAttribute('id').split('_').pop();
                const deleteForm = document.getElementById(`deleteForm_${adminId}`);

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire("Terhapus!", "Data ini berhasil dihapus.", "success");
                        deleteForm.submit();
                    }
                });
            });
        });
    });
</script>


<!-- Tambah Modal -->
<div class="modal fade tambah" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Data Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin">
                    @csrf
                    <div class="row mb-4">
                        <label for="horizontal-Fullname-input" class="col-sm-3 col-form-label">Kode Admin</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Masukkan Kode Admin" name="nips" id="nips" autofocus required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Masukkan Nama" name="name" id="name" required>
                        </div>
                    </div>
                    <input type="hidden" name="is_admin" id="is_admin" value="1">

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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- Tambah modal -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-user');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {

                const adminId = this.getAttribute('data-admin-id');
                const adminName = this.getAttribute('data-admin-name');
                const adminNips = this.getAttribute('data-admin-nips');

                const modalId = `#modalEdit_${adminId}`;
                const modal = document.querySelector(modalId);

                modal.querySelector('#name').value = adminName;
                modal.querySelector('#nips').value = adminNips;

                new bootstrap.Modal(modal).show();
            });
        });
    });
</script>
<!-- Edit Modal -->
@foreach ($users as $admin)
<div class="modal fade" id="modalEdit_{{ $admin->id }}"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Data Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="post" action="/admin/{{ $admin->id }}">
                @method('put')
                @csrf
            <div class="modal-body">
                    <div class="row mb-4">
                        <label for="horizontal-Fullname-input" class="col-sm-3 col-form-label">Kode Admin</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('nips', $admin->nips) }}" placeholder="Masukkan Kode Admin" name="nips" id="nips" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('name', $admin->name) }}" placeholder="Masukkan Nama" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="Masukkan Password" name="password" id="password" required>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- Edit Modal -->
@endforeach
@endsection