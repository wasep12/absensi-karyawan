<?php
namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsensiExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * Mendapatkan koleksi data yang akan diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil data absensi sesuai dengan pengurutan berdasarkan bulan dan waktu
        return Absensi::with('Karyawan')
            ->orderBy('tanggal')
            ->orderBy('jam_masuk')
            ->get()
            ->map(function ($item, $index) {  // Menambahkan nomor urut dengan $index
                return [
                    'No' => $index + 1,  // Nomor urut, dimulai dari 1
                    'Kode Rfid' => $item->uid,
                    'Nama Karyawan' => $item->Karyawan ? $item->Karyawan->nama : 'Karyawan Dihapus',
                    'Tanggal' => $item->tanggal,
                    'Jam Masuk' => $item->jam_masuk,
                    'Jam Pulang' => $item->jam_pulang,
                ];
            });
    }

    /**
     * Mendapatkan header dari file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Rfid',
            'Nama Karyawan',
            'Tanggal',
            'Jam Masuk',
            'Jam Pulang',
        ];
    }
}