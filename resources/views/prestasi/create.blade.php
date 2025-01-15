@extends('layouts.main')
@section('container')
<div class="card ">
    <div class="card-body">
        <div class="col-xl-9 mt-4">
            <form method="post" action="/siprestasi">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="kelas" name="kelas" aria-label="Floating label select example">
                                <option value="" selected disabled>Pilih Kelas</option>    
                                @foreach($kelass as $kelas)
                                    <option value="{{ $kelas->nama }}">{{ $kelas->nama }}</option>
                                @endforeach
                            </select>
                            <label for="kelas">Kelas</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="nama" name="nama" aria-label="Floating label select example" disabled>
                                <option value="" selected disabled>Pilih Nama Siswa</option>    
                            </select>
                            <label for="nama">Nama siswa</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nisn" name="nisn" readonly>
                            <label for="nisn">NISN</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="angkatan" name="angkatan" readonly>
                            <label for="angkatan">Angkatan</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="kompetisi" name="kompetisi" aria-label="Floating label select example">
                                <option value="" selected disabled>Pilih kompetisi</option>   
                                <option value="Kompetisi Individu">Kompetisi Individu</option>
                                <option value="Kompetisi Kelompok">Kompetisi Kelompok</option>
                            </select>
                            <label for="kompetisi">Kompetisi</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="juara" name="juara" aria-label="Floating label select example" disabled>
                                <option value="" selected disabled>Pilih Juara</option>
                    
                            </select>
                            <label for="Juara">Juara</label>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="sekolah" id="sekolah">
                <input type="hidden" name="kota" id="kota">
                <input type="hidden" name="provinsi" id="provinsi">
                <input type="hidden" name="nasional" id="nasional">
                <input type="hidden" name="internasional" id="internasional">
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <textarea required class="form-control" rows="10" name="keterangan" id="keterangan"></textarea>
                            <label for="keterangan">Judul Lomba</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-1 m-1 mb-2">
                        <label class="form-label card-title">Tingkat</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="form-check form-check-inline ms-1">
                            <input class="form-check-input" type="radio" name="tingkat" id="tingkatSekolah" value="Sekolah" disabled>
                            <label class="form-check-label" for="tingkatSekolah">Sekolah</label>
                        </div>
                        <div class="form-check form-check-inline ms-4">
                            <input class="form-check-input" type="radio" name="tingkat" id="tingkatKota" value="Kota" disabled>
                            <label class="form-check-label" for="tingkatKota">Kota</label>
                        </div>
                        <div class="form-check form-check-inline ms-4">
                            <input class="form-check-input" type="radio" name="tingkat" id="tingkatProvinsi" value="Provinsi" disabled>
                            <label class="form-check-label" for="tingkatProvinsi">Provinsi</label>
                        </div>
                        <div class="form-check form-check-inline ms-4">
                            <input class="form-check-input" type="radio" name="tingkat" id="tingkatNasional" value="Nasional" disabled>
                            <label class="form-check-label" for="tingkatNasional">Nasional</label>
                        </div>
                        <div class="form-check form-check-inline ms-4">
                            <input class="form-check-input" type="radio" name="tingkat" id="tingkatInternasional" value="Internasional" disabled>
                            <label class="form-check-label" for="tingkatInternasional">Internasional</label>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="poin" name="poin" disabled>
                            <label for="poin">Jumlah Bobot Poin</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="created_at" name="created_at">
                            <label for="created_at">Tanggal</label>
                        </div>
                    </div>
                </div>

                
                <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        var users = @json($users);
        var prestasis = @json($prestasis);

        $('#kompetisi').on('change', function () {
            var selectedKompetisi = $(this).val();
            $('#juara').empty().append('<option value="" selected disabled>Pilih Juara</option>');
            prestasis.forEach(function(prestasi) {
                if (prestasi.kompetisi === selectedKompetisi) {
                    $('#juara').append('<option value="' + prestasi.juara + '">' + prestasi.juara + '</option>');
                }
            });
            $('#juara').prop('disabled', false);
            $('input[name="tingkat"]').prop('disabled', false);
            $('#poin').prop('disabled', false);
        });

        $('#juara').on('change', function () {
            var selectedJuara = $(this).val();
            var selectedKompetisi = $('#kompetisi').val();
        var prestasiSelected = prestasis.find(function(prestasi) {
            return prestasi.juara == selectedJuara && prestasi.kompetisi == selectedKompetisi;
        });
            if (prestasiSelected) {
                $('#sekolah').val(prestasiSelected.sekolah);
                $('#kota').val(prestasiSelected.kota);
                $('#provinsi').val(prestasiSelected.provinsi);
                $('#nasional').val(prestasiSelected.nasional);
                $('#internasional').val(prestasiSelected.internasional);

                // Update bobot poin based on selected tingkat
                updateBobotPoin();
            }
        });

        $('input[name="tingkat"]').on('change', function () {
            updateBobotPoin();
        });

        function updateBobotPoin() {
            var selectedTingkat = $('input[name="tingkat"]:checked').val();
            var poin = '';

            switch(selectedTingkat) {
                case 'Sekolah':
                    poin = $('#sekolah').val();
                    break;
                case 'Kota':
                    poin = $('#kota').val();
                    break;
                case 'Provinsi':
                    poin = $('#provinsi').val();
                    break;
                case 'Nasional':
                    poin = $('#nasional').val();
                    break;
                case 'Internasional':
                    poin = $('#internasional').val();
                    break;
                default:
                    poin = '';
            }

            $('#poin').val(poin);
        }

        $('#kelas').on('change', function () {
            var selectedKelas = $(this).val();
            var filteredUsers = users.filter(function(user) {
                return user.kelas === selectedKelas;
            });

            $('#nama').empty().append('<option value="" selected disabled>Pilih Nama Siswa</option>');
            filteredUsers.forEach(function(user) {
                $('#nama').append('<option value="' + user.name + '">' + user.name + '</option>');
            });

            $('#nama').prop('disabled', false);
        });

        $('#nama').on('change', function () {
            var selectedSiswa = $(this).val();
            var selectedUser = users.find(user => user.name === selectedSiswa);

            if (selectedUser) {
                $('#nisn').val(selectedUser.nips);
                $('#angkatan').val(selectedUser.angkatan);
            }
        });
    });
</script>

<!--Javascript !-->
<script>
    $(document).ready(function () {
        // Set default date to today's date
        var today = new Date().toISOString().split('T')[0];
        $('#created_at').val(today);
    });
</script>
@endsection
