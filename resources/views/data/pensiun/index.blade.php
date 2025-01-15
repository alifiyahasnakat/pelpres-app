@extends('layouts.main')
@section('container')
<h4><b>Data Guru Pensiun</b></h4>

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
                        <th>NIP</th>
                        <th>Nama</th>
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
    });

    document.addEventListener('DOMContentLoaded', function () {
        const toggleSwitches = document.querySelectorAll('.toggle-status');

        toggleSwitches.forEach(function (toggleSwitch) {
            toggleSwitch.addEventListener('change', function () {
                const guruId = this.getAttribute('data-guru-id');
                const isChecked = this.checked;

                // Kirim request Ajax ke backend untuk mengubah status
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
                    // Tampilkan pesan sukses atau handle respons lainnya
                    console.log('Status updated successfully:', data);
                    // Jika perlu, tambahkan feedback visual atau notifikasi di sini
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                    // Tampilkan pesan error atau handle kesalahan lainnya
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
                    <div class="row mb-4">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="Masukkan Password" name="password" id="password" required>
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
@endsection
