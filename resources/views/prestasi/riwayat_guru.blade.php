@extends('layouts.main')
@section('container')

    <h4><b>Riwayat Prestasi Siswa</b></h4>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="float-end">
                        <div class=" mb-3">
                            <div class="input-group">
                                <input type="date" class="form-control text-start" id="fromDate" placeholder="From" name="fromDate">
                                <input type="date" class="form-control text-start" id="toDate" placeholder="To" name="toDate">
                                <button type="button" class="btn btn-primary" onclick="applyDateFilter()"><i class="mdi mdi-filter-variant"></i> Filter</button>
                                <button type="button" class="btn btn-success waves-effect waves-light me-2" onclick="exportToExcel()"><i class="mdi mdi-google-spreadsheet me-1"></i> Export</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">

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
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Angkatan</th>
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
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>{{ $siswa->angkatan }}</td>
                        <td>{{ $siswa->kompetisi }}</td>
                        <td>{{ $siswa->juara }}</td>
                        <td>{{ $siswa->tingkat }}</td>
                        <td>{{ $siswa->poin }}</td>
                        <td>{{ $siswa->keterangan }}</td>
                        <td>{{ $siswa->created_at->format('Y-m-d') }}</td>
                        <td>{{ $siswa->created_by}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

<script>
 function applyDateFilter() {
    var fromDate = document.getElementById('fromDate').value;
    var toDate = document.getElementById('toDate').value;

    var table = document.getElementById('datatable');
    var tr = table.getElementsByTagName('tr');

    for (var i = 1; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName('td');
        var dateColumn = td[9].textContent.trim(); // Tanggal is the 10th column (index 9)

        if (fromDate && toDate) {
            var dateValue = new Date(dateColumn);
            var fromValue = new Date(fromDate);
            var toValue = new Date(toDate);

            if (dateValue >= fromValue && dateValue <= toValue) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        } else {
            tr[i].style.display = '';
        }
    }
}
    function exportToExcel() {
        var table = document.getElementById("datatable");
        var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet JS" });

        XLSX.writeFile(wb, "riwayat_prestasi_siswa.xlsx");
    }
</script>
@endsection