@extends('layouts.main')
@section('container')
<h4><b>Kelola Data Guru</b></h4>

<div class="card">
    <div class="card-body">
        <a href="" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target=".tambah">
            <i class="fas fa-user-plus me-1"></i>Tambah Data Guru
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Kata Sandi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $guru)
                    <tr>
                        <td>
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck{{ $guru->id }}">
                                <label class="form-check-label" for="ordercheck{{ $guru->id }}"></label>
                            </div>
                        </td>
                        <td>{{ $guru->nips }}</td>
                        <td>{{ $guru->name }}</td>
                        <td>{{ $guru->password }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input toggle-status" id="toggleStatus_{{ $guru->id }}"
                                        data-guru-id="{{ $guru->id }}"
                                        @if ($guru->is_guru) checked @endif
                                        value="{{ $guru->is_guru }}">
                                <label class="form-check-label" for="toggleStatus_{{ $guru->id }}"></label>
                            </div>
                        </td>
                        <td class="d-flex align-items-center justify-content-center">
                            <a class="btn p-0 mx-3 text-primary edit-user" data-bs-toggle="modal" data-bs-target=".modalEdit"
                                data-guru-id="{{ $guru->id }}" 
                                data-guru-name="{{ $guru->name }}" 
                                data-guru-nips="{{ $guru->nips }}">
                                <i class="uil uil-pen font-size-18"></i>
                            </a>

                            <form action="/guru/{{ $guru->id }}" method="post" id="deleteForm_{{ $guru->id }}">
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
                const guruId = this.closest('form').getAttribute('id').split('_').pop();
                const deleteForm = document.getElementById(`deleteForm_${guruId}`);

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

        const toggleSwitches = document.querySelectorAll('.toggle-status');

        toggleSwitches.forEach(function (toggleSwitch) {
            toggleSwitch.addEventListener('change', function () {
                const guruId = this.getAttribute('data-guru-id');
                const isChecked = this.checked;
                const toggleElement = this;

                Swal.fire({
                    title: 'Konfirmasi Perubahan Status',
                    text: 'Anda yakin ingin mengubah status guru ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/guru/${guruId}/status`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                is_guru: isChecked
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire("Berhasil!", "Status guru berhasil diubah.", "success").then(() => {
                                window.location.reload();
                            });
                        })
                        .catch(error => {
                            console.error('Error updating status:', error);
                            Swal.fire("Error!", "Terjadi kesalahan saat mengubah status.", "error");
                        });
                    } else {
                        toggleElement.checked = !isChecked;
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
                <h5 class="modal-title">Form Tambah Data Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/guru">
                    @csrf
                    <div class="row mb-4">
                        <label for="horizontal-Fullname-input" class="col-sm-3 col-form-label">NIP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Masukkan NIP" name="nips" id="nips" autofocus required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Masukkan Nama" name="name" id="name" required>
                        </div>
                    </div>
                    <input type="hidden" name="is_guru" id="is_guru" value="1">

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

                const guruId = this.getAttribute('data-guru-id');
                const guruName = this.getAttribute('data-guru-name');
                const guruNips = this.getAttribute('data-guru-nips');

                const modalId = `#modalEdit_${guruId}`;
                const modal = document.querySelector(modalId);

                modal.querySelector('#name').value = guruName;
                modal.querySelector('#nips').value = guruNips;

                new bootstrap.Modal(modal).show();
            });
        });
    });
</script>

<!-- Edit Modal -->
@foreach ($users as $guru)
<div class="modal fade" id="modalEdit_{{ $guru->id }}"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Data Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="post" action="/guru/{{ $guru->id }}">
                @method('put')
                @csrf
            <div class="modal-body">
                    <div class="row mb-4">
                        <label for="horizontal-Fullname-input" class="col-sm-3 col-form-label">NIP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('nips', $guru->nips) }}" placeholder="Masukkan NiP" name="nips" id="nips" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('name', $guru->name) }}" placeholder="Masukkan Nama" name="name" id="name" required>
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
