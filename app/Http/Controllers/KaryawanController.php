<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use App\Models\RfidTemp;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Karyawan::All();
        return view('karyawan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $delete = DB::table('temp_rfid')->delete();
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kartu' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        // Simpan data karyawan
        $karyawan = Karyawan::create([
            'uid' => $validated['kartu'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'jabatan' => $validated['jabatan'],
        ]);

        // Hapus data dari tabel temp_rfid setelah penyimpanan
        DB::table('temp_rfid')->delete();

        // return redirect()->back()->with('success', 'Data Karyawan Berhasil Ditambahkan !!');
        // Redirect dengan pesan sukses
        return redirect('/karyawan')->with('success', 'Data Berhasil Ditambahkan !!');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Karyawan::where('id', $id)->get();
        return view('Karyawan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data = Karyawan::where('id', $id)->update([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'jabatan' => $request->input('jabatan'),
        ]);

        return redirect('/karyawan')->with('success', 'Data Berhasil Diedit !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Temukan data karyawan berdasarkan ID
        $karyawan = Karyawan::findOrFail($id);

        // Hapus semua absensi yang terkait dengan karyawan
        Absensi::where('uid', $karyawan->uid)->delete();

        // Hapus data karyawan
        $karyawan->delete();

        // Redirect dengan pesan sukses
        return redirect('/karyawan')->with('success', 'Data Karyawan dan Absensi Terkait Berhasil Dihapus !!');
    }
}