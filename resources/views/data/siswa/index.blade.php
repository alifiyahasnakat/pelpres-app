@extends('layouts.main')
@section('container')

    <h4><b>Kelola Data Siswa</b></h4>
    
    <div class="card">
        <div class="card-body">
        <a href="" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target=".tambah">
            <i class="fas fa-user-plus me-1"
            ></i>Tambah Data Siswa
        </a>
        <button type="button" class="btn btn-danger waves-effect waves-light me-2 float-end" data-bs-toggle="modal" data-bs-target=".import"><i class="mdi mdi-google-spreadsheet me-1"></i> Import</button>
        <div class="modal fade import" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('siswa.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control" name="file" accept=".xlsx, .csv" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>No Telepon</th>
                        <th>Kelas</th>
                        <th>Angkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $siswa)
                    <tr data-poin-prestasi="{{ $siswa->poin_prestasi }}" data-poin-pelanggaran="{{ $siswa->poin_pelanggaran }}">
                        <td>
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="ordercheck{{ $siswa->id }}">
                                <label class="form-check-label" for="ordercheck"></label>
                            </div>
                        </td>
                        <td>{{ $siswa->nips }}</td>
                        <td>{{ $siswa->name }}</td>
                        <td>{{ $siswa->nohp }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>{{ $siswa->angkatan }}</td>
                        <td class="d-flex align-items-center justify-content-center">
                            <a class="btn p-0 mx-3 text-primary edit-user" data-bs-toggle="modal" data-bs-target=".modalEdit"
                            data-siswa-id="{{ $siswa->id }}" 
                            data-siswa-name="{{ $siswa->name }}" 
                            data-siswa-nips="{{ $siswa->nips }}"
                            data-siswa-nohp="{{ $siswa->nohp }}"
                            data-siswa-kelas="{{ $siswa->kelas }}"
                                data-siswa-angkatan="{{ $siswa->angkatan }}"
                                >
                                <i class="uil uil-pen font-size-18"></i>
                            </a>
                            
                            <form action="/siswa/{{ $siswa->id }}" method="post" id="deleteForm_{{ $siswa->id }}">
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
                const siswaRow = this.closest('tr');
                const poinPrestasi = parseFloat(siswaRow.getAttribute('data-poin-prestasi'));
            const poinPelanggaran = parseFloat(siswaRow.getAttribute('data-poin-pelanggaran'));
            
          
                console.log('Poin Prestasi:', poinPrestasi);
                console.log('Poin Pelanggaran:', poinPelanggaran);
                if (poinPrestasi !== 0 || poinPelanggaran !== 0) {
                    Swal.fire({
                        title: 'Gagal Menghapus',
                        text: 'Data tidak bisa dihapus karena masih memiliki poin prestasi atau pelanggaran.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    const siswaId = this.closest('form').getAttribute('id').split('_').pop();
                    const deleteForm = document.getElementById(`deleteForm_${siswaId}`);

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
                }
            });
        });
    });
</script>


<!-- Tambah Modal -->
<div class="modal fade tambah" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/siswa">
                    @csrf
                    <div class="row mb-4">
                        <label for="horizontal-Fullname-input" class="col-md-3 col-form-label">NISN</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Masukkan NISN" name="nips" id="nips" autofocus required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-email-input" class="col-md-3 col-form-label">Nama</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Masukkan Nama" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-nohp-input" class="col-md-3 col-form-label">No Telepon</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Masukkan No Telepon" name="nohp" id="nohp" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-kelas-input" class="col-md-3 col-form-label">Kelas</label>
                        <div class="col-md-9">
                            <select class="form-select" id="kelas" name="kelas" aria-label="Floating label select example">
                                <option value="" selected disabled>Pilih Kelas</option>    
                                @foreach($kelass as $kelas)
                                    <option value="{{ $kelas->nama }}">{{ $kelas->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-angkatan-input" class="col-md-3 col-form-label">Angkatan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Masukkan Angkatan" name="angkatan" id="angkatan" required>
                        </div>
                    </div>
                    <input type="hidden" name="is_siswa" id="is_siswa" value="1">
                    
                    <div class="row justify-content-end">
                        <div class="col-md-9">
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

                const siswaId = this.getAttribute('data-siswa-id');
                const siswaName = this.getAttribute('data-siswa-name');
                const siswaNips = this.getAttribute('data-siswa-nips');
                const siswaNohp = this.getAttribute('data-siswa-nohp');
                const siswaKelas = this.getAttribute('data-siswa-kelas');
                const siswaAngkatan = this.getAttribute('data-siswa-angkatan');
                
                const modalId = `#modalEdit_${siswaId}`;
                const modal = document.querySelector(modalId);
                
                modal.querySelector('#name').value = siswaName;
                modal.querySelector('#nips').value = siswaNips;
                modal.querySelector('#nohp').value = siswaNohp;
                modal.querySelector('#kelas').value = siswaKelas;
                modal.querySelector('#angkatan').value = siswaAngkatan;

                new bootstrap.Modal(modal).show();
            });
        });
    });
</script>
<!-- Edit Modal -->
@foreach ($users as $siswa)
<div class="modal fade" id="modalEdit_{{ $siswa->id }}"  tabindex="-1" role="dialog" aria-labelledby="mysmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form method="post" action="/siswa/{{ $siswa->id }}">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <label for="horizontal-nisn-input" class="col-sm-3 col-form-label">NISN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('nips', $siswa->nips) }}" name="nips" id="nips" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-nama-input" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('name', $siswa->name) }}" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="Masukkan Password" name="password" id="password" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-nohp-input" class="col-sm-3 col-form-label">No Telepon</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('nohp', $siswa->nohp) }}" name="nohp" id="nohp" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-kelas-input" class="col-sm-3 col-form-label">Kelas</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="kelas" name="kelas" aria-label="Floating label select example">
                                <option value="{{ old('kelas', $siswa->kelas) }}" selected>{{ old('kelas', $siswa->kelas) }}</option>    
                                @foreach($kelass as $kelas)
                                    <option value="{{ $kelas->nama }}">{{ $kelas->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="horizontal-angkatan-input" class="col-sm-3 col-form-label">Angkatan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ old('angkatan', $siswa->angkatan) }}" name="angkatan" id="angkatan" required>
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