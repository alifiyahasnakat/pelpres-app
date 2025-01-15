@extends('layouts.main')
@section('container')
<div class="row">
    <h4><b> Detail Prestasi Siswa</b></h4>

    <div class="col-xl-8">
        <div class="mt-5 mt-lg-0">
            <div class="card border shadow-none">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">NISN <span class="float-end">{{ $siswaDetail->nips }}</span></h5>
                </div>
                <div class="card-body p-4">

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Nama </td>
                                    <td class="text-end">{{ $siswaDetail->name }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas </td>
                                    <td class="text-end">{{ $siswaDetail->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>Angkatan </td>
                                    <td class="text-end">{{ $siswaDetail->angkatan }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <th>Total Poin Prestasi</th>
                                    <td class="text-end">
                                        <span class="fw-bold">
                                            {{ $siswaDetail->poin_prestasi }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
    
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
                        <td>
                            <form action="{{ route('prestasi.destroy', ['nips' => $siswaDetail->nips, 'id' => $siswa->id]) }}" method="post" id="deleteForm_{{ $siswa->id }}">
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
                    deleteForm.submit();
                }
            });
        });
    });
});

</script>
@endsection