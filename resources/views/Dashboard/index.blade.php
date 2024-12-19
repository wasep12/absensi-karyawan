@extends('layout.main')
@section('title', 'Dashboard')
@section('judul_halaman', 'SELAMAT DATANG DI SISTEM ABSENSI PINTAR MENGGUNAKAN RFID!👋')

@section('isi')
<div class="row">
    <!-- Statistik Jumlah Karyawan -->
    <div class="col-md-6">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Jumlah Karyawan</h4>
                </div>
                <div class="card-body">
                    {{$karyawan}}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Kehadiran -->
    <div class="col-md-6">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="far fa-calendar"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Jumlah Karyawan Presensi Hari Ini</h4>
                </div>
                <div class="card-body">
                    {{$presensi}}
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown untuk Memilih Bulan -->
    <div class="col-md-12 mb-3">
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="form-group">
                <label for="bulan">Pilih Bulan:</label>
                <select name="bulan" id="bulan" class="form-control" onchange="this.form.submit()">
                    @foreach($bulanOptions as $key => $value)
                        <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Grafik Kehadiran Per Hari di Bulan yang Dipilih -->
    <div class="col-md-12">
        <canvas id="kehadiranChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Mengirim data dari Blade ke JavaScript
    var labels = @json($labels); // Hari dalam bulan
    var data = @json($data); // Jumlah kehadiran per hari

    // Grafik Kehadiran Per Hari
    var ctx = document.getElementById('kehadiranChart').getContext('2d');
    var kehadiranChart = new Chart(ctx, {
        type: 'line', // Jenis grafik (bisa diganti sesuai keinginan)
        data: {
            labels: labels, // Hari
            datasets: [{
                label: 'Jumlah Kehadiran',
                data: data, // Data (jumlah kehadiran)
                borderColor: 'rgb(75, 192, 192)', // Warna garis
                fill: false, // Tidak ada area yang diisi
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.raw + ' orang'; // Menampilkan jumlah kehadiran
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true // Mulai sumbu Y dari 0
                }
            }
        }
    });
</script>

@endsection