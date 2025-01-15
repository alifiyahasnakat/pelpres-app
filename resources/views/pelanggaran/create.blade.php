@extends('layouts.main')
@section('container')
<div class="card">
    <div class="card-body">
        <div class="col-xl-9 mt-4">
            <form method="post" action="/sipelanggaran">
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
                                @foreach($users as $siswa)
                                    <option value="{{ $siswa->name }}" data-kelas="{{ $siswa->kelas }}">{{ $siswa->name }}</option>
                                @endforeach
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
                            <select class="form-select" id="kategori" name="kategori" aria-label="Floating label select example">
                                <option value="" selected disabled>Pilih Kategori Pelanggaran</option>
                                @foreach($pelanggarans->pluck('kategori')->unique() as $kategori)
                                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                                @endforeach
                            </select>
                            <label for="kategori">Kategori Pelanggaran</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="jenis" name="jenis" aria-label="Floating label select example" disabled>
                                <option value="" selected disabled>Pilih Jenis Pelanggaran Siswa</option>
                                @foreach($pelanggarans as $jenis)
                                    <option value="{{ $jenis->item }}" data-kategori="{{ $jenis->kategori }}">{{ $jenis->item }}</option>
                                @endforeach
                            </select>
                            <label for="jenis">Jenis Pelanggaran siswa</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="poin" name="poin" readonly>
                            <label for="poin">Poin</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="created_at" name="created_at">
                            <label for="created_at">Tanggal</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <textarea required class="form-control" rows="10" name="keterangan" id="keterangan"></textarea>
                            <label for="keterangan">Keterangan</label>
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
        $('#kelas').on('change', function () {
            var selectedKelas = $(this).val();
            $('#nama').prop('disabled', false);
            $('#nama').find('option').each(function () {
                if ($(this).data('kelas') == selectedKelas) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#nama').val('');
            $('#nisn').val('');
            $('#angkatan').val('');
        });

        $('#nama').on('change', function () {
            var selectedSiswa = $(this).val();

            var selectedNisn = @json($users->pluck('nips', 'name'));
            var selectedAngkatan = @json($users->pluck('angkatan', 'name'));

            $('#nisn').val(selectedNisn[selectedSiswa]);
            $('#angkatan').val(selectedAngkatan[selectedSiswa]);
        });

        $('#kategori').on('change', function () {
            var selectedKategori = $(this).val();
            $('#jenis').prop('disabled', false);
            $('#jenis').find('option').each(function () {
                if ($(this).data('kategori') == selectedKategori) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#jenis').val('');
            $('#poin').val('');
        });

        $('#jenis').on('change', function () {
            var selectedPelanggaran = $(this).val();

            var selectedPoin = @json($pelanggarans->pluck('poin', 'item'));

            $('#poin').val(selectedPoin[selectedPelanggaran]);
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Set default date to today's date
        var today = new Date().toISOString().split('T')[0];
        $('#created_at').val(today);
    });
</script>
@endsection
