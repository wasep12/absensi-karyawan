<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mode;

class SettingsController extends Controller
{
    public function index()
    {
        $mode = Mode::first();
        return view('settings.index', compact('mode'));
    }

    public function update(Request $request)
    {
        // Validasi inputan dengan custom message
        $validated = $request->validate([
            'waktu_masuk' => 'nullable|date_format:H:i', // Pastikan format H:i
            'waktu_pulang' => 'nullable|date_format:H:i', // Pastikan format H:i
        ], [
            // Custom error messages
            'waktu_masuk.date_format' => 'Waktu Masuk harus diisi lagi menggunakan format H:i, misalnya 08:00.',
            'waktu_pulang.date_format' => 'Waktu Pulang harus diisi lagi menggunakan format H:i, misalnya 17:00.',
        ]);

        // Ambil mode yang ada di database
        $mode = Mode::first();

        // Tentukan nilai waktu masuk dan pulang berdasarkan perubahan atau nilai lama
        $waktuMasuk = $validated['waktu_masuk'] ?? $mode->waktu_masuk;
        $waktuPulang = $validated['waktu_pulang'] ?? $mode->waktu_pulang;

        // Update mode dengan nilai yang sudah diperbarui
        $mode->update([
            'waktu_masuk' => $waktuMasuk,
            'waktu_pulang' => $waktuPulang,
        ]);

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function mode()
    {
        $mode = Mode::first();
        $newMode = $mode->mode == 1 ? 2 : 1;
        $mode->update(['mode' => $newMode]);

        return redirect()->route('settings.index')->with('success', 'Mode absensi berhasil diubah!');
    }
}