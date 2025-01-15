@extends('layouts.main')

@section('container')
<div class="row">
    <h4><b>Kelola Pindah/Naik Kelas</b></h4>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h4 class="card-title"></h4>
                <form id="pindahKelasForm" method="POST" action="{{ route('pindah-naik.update') }}">
                    @csrf
                    <div class="row align-items-start">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="kelas_dari">Dari Kelas</label>
                                <select class="form-select" id="kelas_dari" name="kelas_dari" aria-label="Floating label select example">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    @foreach($kelass as $kelas)
                                            <option value="{{ $kelas->nama }}">{{ $kelas->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="kelas_tujuan">Pindah/Naik ke</label>
                                <select class="form-select" id="kelas_tujuan" name="kelas_tujuan" aria-label="Floating label select example">
                                    <option value="" selected disabled>Pilih Kelas</option>
                                    @foreach($kelass as $kelas)
                                        <option value="{{ $kelas->nama }}">{{ $kelas->nama }}</option>
                                    @endforeach
                                    <option value="Alumni">Alumni</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="siswaTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Angkatan</th>
                                    <th>No. HP</th>
                                </tr>
                            </thead>
                            <tbody id="siswaBody">
                                <!-- Data siswa akan ditampilkan di sini -->
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Pindahkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const kelasDariDropdown = document.getElementById('kelas_dari');
        const siswaTableBody = document.getElementById('siswaBody');
        const selectAllCheckbox = document.getElementById('selectAll');
        const pindahKelasForm = document.getElementById('pindahKelasForm');

        kelasDariDropdown.addEventListener('change', function () {
            const selectedKelas = this.value;

            // Kirim permintaan Ajax ke backend untuk mendapatkan data siswa berdasarkan kelas
            fetch(`/siswa/by_kelas/${selectedKelas}`)
                .then(response => response.json())
                .then(data => {
                    // Bersihkan isi tabel sebelum menambahkan data baru
                    siswaTableBody.innerHTML = '';

                    // Tambahkan baris baru untuk setiap siswa
                    data.forEach(siswa => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><input type="checkbox" class="siswaCheckbox" name="siswa_ids[]" value="${siswa.id}"></td>
                            <td>${siswa.nips}</td>
                            <td>${siswa.name}</td>
                            <td>${siswa.kelas}</td>
                            <td>${siswa.angkatan}</td>
                            <td>${siswa.nohp}</td>
                        `;
                        siswaTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });

        selectAllCheckbox.addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.siswaCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        pindahKelasForm.addEventListener('submit', function (event) {
            const kelasTujuan = document.getElementById('kelas_tujuan').value;
            if (!kelasTujuan) {
                event.preventDefault();
                alert('Pilih kelas tujuan terlebih dahulu.');
            }
        });
    });
</script>

@endsection
