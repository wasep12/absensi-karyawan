<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redis;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Mode;
use App\Models\RfidTemp;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use Barryvdh\DomPDF\Facade\Pdf;
class PagesController extends Controller
{
    public function dashboard(Request $request)
    {
        $karyawan = Karyawan::count(); // Menghitung jumlah karyawan
        $curdate = now()->toDateString(); // Tanggal hari ini
        $presensi = Absensi::where('tanggal', $curdate)->count(); // Menghitung absensi hari ini

        // Ambil bulan yang dipilih, jika tidak ada maka default ke bulan ini
        $bulan = $request->bulan ?? now()->month; // Menentukan bulan yang dipilih, default ke bulan sekarang
        $tahun = now()->year; // Tahun sekarang

        // Ambil jumlah kehadiran per hari untuk bulan yang dipilih
        $absensi_per_hari = Absensi::selectRaw('DAY(tanggal) as hari, COUNT(*) as total')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan) // Filter berdasarkan bulan yang dipilih
            ->groupBy('hari')
            ->orderBy('hari')
            ->get();

        // Siapkan data untuk chart
        $labels = [];  // Tanggal dalam bulan
        $data = [];    // Jumlah kehadiran per hari

        foreach ($absensi_per_hari as $absensi) {
            $labels[] = $absensi->hari;  // Menyimpan hari
            $data[] = $absensi->total;   // Menyimpan total kehadiran per hari
        }

        // Siapkan daftar bulan untuk dropdown
        $bulanOptions = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return view('Dashboard.index', compact('karyawan', 'presensi', 'labels', 'data', 'bulanOptions', 'bulan'));
    }

    public function absensi()
    {
        $absensi = Absensi::all(); // Dapat disesuaikan dengan paginasi jika data sangat banyak
        return view('rekap.index', compact('absensi'));
    }
    public function exportCsv()
    {
        return Excel::download(new AbsensiExport, 'data_absensi.csv', ExcelType::CSV);
    }

    public function exportPdf()
    {
        // Ambil data absensi
        $absensi = Absensi::with('Karyawan')
            ->orderBy('tanggal')
            ->orderBy('jam_masuk')
            ->get();

        // Menggunakan view untuk PDF, pastikan path sesuai dengan lokasi file view
        $pdf = Pdf::loadView('exports.absensi_pdf', compact('absensi'));

        // Mengunduh file PDF
        return $pdf->download('data_absensi.pdf');
    }

    public function scan()
    {
        return view('scan.index');
    }

    // Real-time
    public function nokartu()
    {
        $data = RfidTemp::all();
        $cek = RfidTemp::pluck('uid'); // Menggunakan pluck untuk efisiensi

        return view('Karyawan.nokartu', compact('data', 'cek'));
    }

    public function scan_absen()
    {
        RfidTemp::truncate(); // Menghapus data sementara RFID
        return view('scan.index');
    }

    public function reader()
    {
        $mode = Mode::first(); // Ambil mode absensi
        $mode_absen = $mode->mode;
        $text_mode = $mode_absen == 1 ? "Jam Masuk" : "Jam Pulang";
        $hasil = null;
        $nama = "";

        // Ambil UID pertama (sementara)
        $rfidTemp = RfidTemp::first();

        // Cek apakah ada data RFID
        if ($rfidTemp) {
            $rfid_masuk = $rfidTemp->uid;
            $karyawan = Karyawan::where('uid', $rfid_masuk)->first(); // Ambil data karyawan berdasarkan UID

            if ($karyawan) {
                $nama = $karyawan->nama;
                $tanggal = now()->toDateString(); // Menggunakan helper Laravel untuk tanggal
                $jam = now()->toTimeString(); // Menggunakan helper Laravel untuk waktu

                // Cek apakah karyawan sudah absen pada hari ini
                $absensi = Absensi::where('uid', $rfid_masuk)->where('tanggal', $tanggal)->exists();

                if (!$absensi) {
                    $hasil = 0; // Belum absen
                    Absensi::create([
                        'uid' => $rfid_masuk,
                        'tanggal' => $tanggal,
                        'jam_masuk' => $jam,
                        'jam_pulang' => "-",
                    ]);
                } else {
                    // Proses untuk jam pulang
                    if ($mode_absen == 2) {
                        $hasil = 2; // Jam pulang
                        Absensi::where('uid', $rfid_masuk)->where('tanggal', $tanggal)->update([
                            'jam_pulang' => $jam,
                        ]);
                    } else {
                        $hasil = 4; // Sudah absen masuk
                    }
                }
            } else {
                $hasil = 3; // Karyawan tidak terdaftar
            }
        } else {
            $hasil = 1; // Tidak ada data RFID
        }

        // Menghapus data sementara RFID
        RfidTemp::truncate();

        return view('scan.reader', compact('hasil', 'text_mode', 'nama'));
    }

    // Metode dari Arduino untuk menambahkan UID ke tabel RfidTemp
    public function temp($id)
    {
        RfidTemp::truncate(); // Menghapus data RFID sementara
        RfidTemp::create(['uid' => $id]); // Menambahkan UID RFID baru

        return 'Kartu Masuk';
    }

    // Mengubah mode absensi (Jam Masuk / Jam Pulang)
    public function mode()
    {
        $data = Mode::first();
        $mode = $data->mode + 1;
        if ($mode > 2) {
            $mode = 1; // Kembali ke mode Jam Masuk jika sudah mencapai Jam Pulang
        }

        Mode::where('id', 1)->update(['mode' => $mode]);

        return "Mode Berhasil Diubah";
    }
}