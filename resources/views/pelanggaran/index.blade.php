@extends('layouts.main')
@section('container')
<div class="row">
    <div class="col-12">
    <h4><b>Kelola Data Pelanggaran</b></h4>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    @can('superAdmin')
                    <a href="" class="btn btn-success waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target=".tambah">
                        <i class="fas fa-plus me-1"></i>Tambah Data Pelanggaran
                    </a>
                    @endcan
                    <div class="d-flex align-items-center">
                        <label for="filterKategori" class="form-label me-2 mb-0">Pilih Kategori Pelanggaran</label>
                        <select class="form-select" id="filterKategori" style="width: auto;">
                            <option value="">Semua Kategori</option>
                            <option value="Kategori Ringan dan Sedang">Kategori Ringan dan Sedang</option>
                            <option value="Kategori Berat">Kategori Berat</option>
                            <option value="Kategori Sangat Berat">Kategori Sangat Berat</option>
                        </select>
                    </div>
                </div>
                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-editable table-nowrap align-middle table-edits">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Pelanggaran</th>
                                <th>Poin</th>
                            @can('superAdmin')
                                <th>Aksi</th>
                            @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $counter = 1;
                                $groupedPelanggarans = $pelanggarans->groupBy('kategori'); 
                            @endphp
                            @foreach ($groupedPelanggarans as $kategori => $pelanggaranGroup)
                            <tr class="kategori-row" data-kategori="{{ $kategori }}">
                                <td align="center" colspan="5"><b>{{ $kategori }}</b></td>
                            </tr>
                            @foreach ($pelanggaranGroup as $pelanggaran)
                            <tr class="pelanggaran-row" data-kategori="{{ $kategori }}">
                                <td style="width: 80px">{{ $counter++ }}</td>
                                <td>{{ $pelanggaran->item }}</td>
                                <td>{{ $pelanggaran->poin }}</td>
                                @can('superAdmin')
                                <td style="width: 100px" class="d-flex align-items-center justify-content-center">
                                    <a class="btn btn-outline-secondary btn-sm edit-pelanggaran" data-bs-toggle="modal" data-bs-target=".modalEdit"
                                    data-pelanggaran-id="{{ $pelanggaran->id }}" 
                                    data-pelanggaran-item="{{ $pelanggaran->item }}" 
                                    data-pelanggaran-poin="{{ $pelanggaran->poin }}"
                                    data-pelanggaran-kategori="{{ $pelanggaran->kategori }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="/pelanggaran/{{ $pelanggaran->id }}" method="post" id="deleteForm_{{ $pelanggaran->id }}">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-outline-secondary btn-sm m-1 text-danger deleteBtn" type="button">
                                            <i class="fas fa-trash-alt"></i> 
                                        </button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // Fix the variable name here
            const pelanggaranId = this.closest('form').getAttribute('id').split('_').pop();
            const deleteForm = document.getElementById(`deleteForm_${pelanggaranId}`);

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
                <h5 class="modal-title">Form Tambah Data Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/pelanggaran">
                    @csrf
                    <div class="row mb-4">
                        <label for="horizontal-item-input" class="col-lg-2 col-form-label">Item</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" placeholder="Masukkan Item" name="item" id="item" autofocus required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-poin-input" class="col-lg-2 col-form-label">Poin</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" placeholder="Masukkan Poin" name="poin" id="poin" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-poin-input" class="col-lg-2 col-form-label">Kategori</label>
                        <div class="col-lg-10">
                            <select class="form-select" name="kategori">
                                <option>Select</option>
                                <option>Kategori Ringan dan Sedang</option>
                                <option>Kategori Berat</option>
                                <option>Kategori Sangat Berat</option>
                            </select>    
                        </div>
                    </div>
  
                    <div class="row justify-content-end">
                        <div class="col-lg-10">
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
        const editButtons = document.querySelectorAll('.edit-pelanggaran');

        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {

                const pelanggaranId = this.getAttribute('data-pelanggaran-id');
                const pelanggaranItem = this.getAttribute('data-pelanggaran-item');
                const pelanggaranPoin = this.getAttribute('data-pelanggaran-poin');
                const pelanggaranKategori = this.getAttribute('data-pelanggaran-kategori');
                
                const modalId = `#modalEdit_${pelanggaranId}`;
                const modal = document.querySelector(modalId);
                
                modal.querySelector('#item').value = pelanggaranItem;
                modal.querySelector('#poin').value = pelanggaranPoin;
                modal.querySelector('#kategori').value = pelanggaranKategori;

                new bootstrap.Modal(modal).show();
            });
        });
    });
</script>
<!-- Edit Modal -->
@foreach ($pelanggarans as $pelanggaran)
<div class="modal fade" id="modalEdit_{{ $pelanggaran->id }}"  tabindex="-1" role="dialog" aria-labelledby="mysmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Data Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="post" action="/pelanggaran/{{ $pelanggaran->id }}">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <label for="horizontal-item-input" class="col-sm-3 col-form-label">Item</label>
                        <div class="col-sm-9">
                            <textarea required class="form-control" rows="10" name="item" id="item">{{ old('item', $pelanggaran->item) }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-poin-input" class="col-sm-3 col-form-label">Poin</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('poin', $pelanggaran->poin) }}" name="poin" id="poin" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-kategori-input" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="kategori" id="kategori">
                                <option>Select</option>
                                <option>Kategori Ringan dan Sedang</option>
                                <option>Kategori Berat</option>
                                <option>Kategori Sangat Berat</option>
                            </select> 
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.deleteBtn');
        const filterKategori = document.getElementById('filterKategori');
        const kategoriRows = document.querySelectorAll('.kategori-row');
        const pelanggaranRows = document.querySelectorAll('.pelanggaran-row');
    
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const pelanggaranId = this.closest('form').getAttribute('id').split('_').pop();
                const deleteForm = document.getElementById(`deleteForm_${pelanggaranId}`);
    
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
    
        filterKategori.addEventListener('change', function() {
            const selectedKategori = this.value;
            
            kategoriRows.forEach(row => {
                const kategori = row.getAttribute('data-kategori');
                row.style.display = selectedKategori === "" || kategori === selectedKategori ? '' : 'none';
            });
    
            pelanggaranRows.forEach(row => {
                const kategori = row.getAttribute('data-kategori');
                row.style.display = selectedKategori === "" || kategori === selectedKategori ? '' : 'none';
            });
        });
    
        const editButtons = document.querySelectorAll('.edit-pelanggaran');
    
        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const pelanggaranId = this.getAttribute('data-pelanggaran-id');
                const pelanggaranItem = this.getAttribute('data-pelanggaran-item');
                const pelanggaranPoin = this.getAttribute('data-pelanggaran-poin');
                const pelanggaranKategori = this.getAttribute('data-pelanggaran-kategori');
    
                const modalId = `#modalEdit_${pelanggaranId}`;
                const modal = document.querySelector(modalId);
    
                modal.querySelector('#item').value = pelanggaranItem;
                modal.querySelector('#poin').value = pelanggaranPoin;
                modal.querySelector('#kategori').value = pelanggaranKategori;
    
                new bootstrap.Modal(modal).show();
            });
        });
    });
    </script>
    
    <!-- Filter Kategori Pelanggaran!-->
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteBtn');
    const filterKategori = document.getElementById('filterKategori');
    const kategoriRows = document.querySelectorAll('.kategori-row');
    const pelanggaranRows = document.querySelectorAll('.pelanggaran-row');

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const pelanggaranId = this.closest('form').getAttribute('id').split('_').pop();
            const deleteForm = document.getElementById(`deleteForm_${pelanggaranId}`);

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

    filterKategori.addEventListener('change', function() {
        const selectedKategori = this.value;
        
        kategoriRows.forEach(row => {
            const kategori = row.getAttribute('data-kategori');
            row.style.display = selectedKategori === "" || kategori === selectedKategori ? '' : 'none';
        });

        pelanggaranRows.forEach(row => {
            const kategori = row.getAttribute('data-kategori');
            row.style.display = selectedKategori === "" || kategori === selectedKategori ? '' : 'none';
        });
    });

    const editButtons = document.querySelectorAll('.edit-pelanggaran');

    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const pelanggaranId = this.getAttribute('data-pelanggaran-id');
            const pelanggaranItem = this.getAttribute('data-pelanggaran-item');
            const pelanggaranPoin = this.getAttribute('data-pelanggaran-poin');
            const pelanggaranKategori = this.getAttribute('data-pelanggaran-kategori');

            const modalId = `#modalEdit_${pelanggaranId}`;
            const modal = document.querySelector(modalId);

            modal.querySelector('#item').value = pelanggaranItem;
            modal.querySelector('#poin').value = pelanggaranPoin;
            modal.querySelector('#kategori').value = pelanggaranKategori;

            new bootstrap.Modal(modal).show();
        });
    });
});
</script>

@endsection