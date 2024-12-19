@extends('layout.main')
@section('title', 'Data Absensi')
@section('judul_halaman', 'Data Absensi')

@section('isi')
<div class="card">
    <div class="card-header d-flex justify-content-end">
        <!-- Tombol untuk Export CSV -->
        <a href="{{ route('export.csv') }}" class="btn btn-success mr-3">Download CSV</a>
        <!-- Tombol untuk Export PDF -->
        <a href="{{ route('export.pdf') }}" class="btn btn-danger">Download PDF</a>
    </div>

    <div class="table-responsive">
        <table id="example1" class="table table-striped table-md">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Rfid</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensi as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->uid}}</td>
                    <td>{{ $item->Karyawan ? $item->Karyawan->nama : 'Karyawan Dihapus' }}</td>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->jam_masuk}}</td>
                    <td>{{$item->jam_pulang}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection