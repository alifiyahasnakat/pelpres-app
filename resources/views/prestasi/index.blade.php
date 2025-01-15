@extends('layouts.main')
@section('container')
<h4 class="mb-0">Bobot Poin Juara Kompetisi Individu</h4>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @can('superAdmin')
                <a href="" class="btn btn-success waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#tambah">
                    <i class="fas fa-plus me-1"
                    ></i>Tambah Data Prestasi
                </a>
                @endcan
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead class="table-info">
                            <tr>
                                <th rowspan="2" class="text-center align-middle">Juara/Tingkat</th>
                                <th colspan="6">Bobot Poin</th>
                            </tr>
                            <tr>
                                <th>Sekolah</th>
                                <th>Kota</th>
                                <th>Provinsi</th>
                                <th>Nasional</th>
                                <th>Internasional</th>
                                @can('superAdmin')
                                <th>Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($individus as $individu)
                            <tr>
                                <th scope="row">{{ $individu->juara }}</th>
                                <td>{{ $individu->sekolah }}</td>
                                <td>{{ $individu->kota }}</td>
                                <td>{{ $individu->provinsi }}</td>
                                <td>{{ $individu->nasional }}</td>
                                <td>{{ $individu->internasional }}</td>
                                @can('superAdmin')
                                <td class="d-flex align-items-center justify-content-center">
                                    <a class="btn btn-outline-secondary btn-sm edit-individu" data-bs-toggle="modal" data-bs-target="#modalEditIndividu"
                                        data-id="{{ $individu->id }}"
                                        data-juara="{{ $individu->juara }}" 
                                        data-sekolah="{{ $individu->sekolah }}" 
                                        data-kota="{{ $individu->kota }}"
                                        data-provinsi="{{ $individu->provinsi }}"
                                        data-nasional="{{ $individu->nasional }}"
                                        data-internasional="{{ $individu->internasional }}"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="/prestasi/{{ $individu->id }}" method="post" id="deleteForm_{{ $individu->id }}">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-outline-secondary p-0 mx-3 text-danger deleteBtn" type="button">
                                            <i class="uil uil-trash-alt font-size-18"></i> 
                                        </button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-0">Bobot Poin Juara Kompetisi Kelompok</h4>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead class="table-info">
                            <tr>
                                <th rowspan="2" class="text-center align-middle">Juara/Tingkat</th>
                                <th colspan="6">Bobot Poin</th>
                            </tr>
                            <tr>
                                <th>Sekolah</th>
                                <th>Kota</th>
                                <th>Provinsi</th>
                                <th>Nasional</th>
                                <th>Internasional</th>
                                @can('superAdmin')
                                <th>Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelompoks as $kelompok)
                            <tr>
                                <th scope="row">{{ $kelompok->juara }}</th>
                                <td>{{ $kelompok->sekolah }}</td>
                                <td>{{ $kelompok->kota }}</td>
                                <td>{{ $kelompok->provinsi }}</td>
                                <td>{{ $kelompok->nasional }}</td>
                                <td>{{ $kelompok->internasional }}</td>
                                @can('superAdmin')
                                <td class="d-flex align-items-center justify-content-center">
                                    <a class="btn btn-outline-secondary btn-sm edit-kelompok" data-bs-toggle="modal" data-bs-target="#modalEditKelompok"
                                        data-id="{{ $kelompok->id }}"
                                        data-juara="{{ $kelompok->juara }}" 
                                        data-sekolah="{{ $kelompok->sekolah }}" 
                                        data-kota="{{ $kelompok->kota }}"
                                        data-provinsi="{{ $kelompok->provinsi }}"
                                        data-nasional="{{ $kelompok->nasional }}"
                                        data-internasional="{{ $kelompok->internasional }}"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="/prestasi/{{ $kelompok->id }}" method="post" id="deleteForm_{{ $kelompok->id }}">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-outline-secondary p-0 mx-3 text-danger deleteBtn" type="button">
                                            <i class="uil uil-trash-alt font-size-18"></i> 
                                        </button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Individu Modal -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Data Tata Tertib Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/prestasi">
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <label for="juara" class="col-sm-3 col-form-label">Kompetisi</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="kompetisi">
                                <option>Select</option>
                                <option value="Kompetisi Individu" >Kompetisi Individu</option>
                                <option value="Kompetisi Kelompok">Kompetisi Kelompok</option>
                            </select> 
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="juara" class="col-sm-3 col-form-label">Juara/Tingkat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="juara" name="juara" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="sekolah" class="col-sm-3 col-form-label">Tk. Sekolah</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sekolah" name="sekolah" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="kota" class="col-sm-3 col-form-label">Tk. Kota</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kota" name="kota" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="provinsi" class="col-sm-3 col-form-label">Tk. Provinsi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="nasional" class="col-sm-3 col-form-label">Tk. Nasional</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nasional" name="nasional" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="internasional" class="col-sm-3 col-form-label">Tk. Internasional</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="internasional" name="internasional" required>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <div class="d-flex flex-wrap gap-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-outline-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#tambah form');

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle individu edit buttons
        const editIndividuButtons = document.querySelectorAll('.edit-individu');

        editIndividuButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const juara = this.getAttribute('data-juara');
                const sekolah = this.getAttribute('data-sekolah');
                const kota = this.getAttribute('data-kota');
                const provinsi = this.getAttribute('data-provinsi');
                const nasional = this.getAttribute('data-nasional');
                const internasional = this.getAttribute('data-internasional');

                const modal = document.querySelector('#modalEditIndividu');

                modal.querySelector('#juara').value = juara;
                modal.querySelector('#sekolah').value = sekolah;
                modal.querySelector('#kota').value = kota;
                modal.querySelector('#provinsi').value = provinsi;
                modal.querySelector('#nasional').value = nasional;
                modal.querySelector('#internasional').value = internasional;

                modal.querySelector('form').setAttribute('action', `/prestasi/${id}`);
            });
        });

        // Handle kelompok edit buttons
        const editKelompokButtons = document.querySelectorAll('.edit-kelompok');

        editKelompokButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const juara = this.getAttribute('data-juara');
                const sekolah = this.getAttribute('data-sekolah');
                const kota = this.getAttribute('data-kota');
                const provinsi = this.getAttribute('data-provinsi');
                const nasional = this.getAttribute('data-nasional');
                const internasional = this.getAttribute('data-internasional');

                const modal = document.querySelector('#modalEditKelompok');

                modal.querySelector('#juara').value = juara;
                modal.querySelector('#sekolah').value = sekolah;
                modal.querySelector('#kota').value = kota;
                modal.querySelector('#provinsi').value = provinsi;
                modal.querySelector('#nasional').value = nasional;
                modal.querySelector('#internasional').value = internasional;

                modal.querySelector('form').setAttribute('action', `/prestasi/${id}`);
            });
        });


    });
    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteBtn');

    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const prestasiId = this.closest('form').getAttribute('id').split('_').pop();
            const deleteForm = document.getElementById(`deleteForm_${prestasiId}`);

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
                    deleteForm.submit();
                }
            });
        });
    });
});

</script>

<!-- Edit Individu Modal -->
<div class="modal fade" id="modalEditIndividu" tabindex="-1" role="dialog" aria-labelledby="editIndividuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Data Individu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <label for="juara" class="col-sm-3 col-form-label">Juara</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="juara" name="juara" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="sekolah" class="col-sm-3 col-form-label">Sekolah</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sekolah" name="sekolah" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="kota" class="col-sm-3 col-form-label">Kota</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kota" name="kota" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="nasional" class="col-sm-3 col-form-label">Nasional</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nasional" name="nasional" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="internasional" class="col-sm-3 col-form-label">Internasional</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="internasional" name="internasional" required>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <div class="d-flex flex-wrap gap-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-outline-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Kelompok Modal -->
<div class="modal fade" id="modalEditKelompok" tabindex="-1" role="dialog" aria-labelledby="editKelompokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Data Kelompok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="row mb-4">
                        <label for="juara" class="col-sm-3 col-form-label">Juara</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="juara" name="juara" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="sekolah" class="col-sm-3 col-form-label">Sekolah</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sekolah" name="sekolah" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="kota" class="col-sm-3 col-form-label">Kota</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kota" name="kota" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="nasional" class="col-sm-3 col-form-label">Nasional</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nasional" name="nasional" required>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="internasional" class="col-sm-3 col-form-label">Internasional</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="internasional" name="internasional" required>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <div class="d-flex flex-wrap gap-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-outline-danger">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
