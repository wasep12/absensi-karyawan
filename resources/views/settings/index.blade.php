@extends('layout.main')

@section('title', 'Pengaturan Absensi')
@section('judul_halaman', 'Pengaturan Absensi')

@section('isi')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container">
    <form action="{{ route('settings.update') }}" method="POST" class="mb-4" id="waktuForm">
        @csrf
        <div class="mb-3">
            <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
            <input type="time" name="waktu_masuk" id="waktu_masuk" value="{{ old('waktu_masuk', $mode->waktu_masuk) }}"
                class="form-control" required>
            @error('waktu_masuk')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="waktu_pulang" class="form-label">Waktu Pulang</label>
            <input type="time" name="waktu_pulang" id="waktu_pulang"
                value="{{ old('waktu_pulang', $mode->waktu_pulang) }}" class="form-control" required>
            @error('waktu_pulang')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" id="submitButton" class="btn btn-primary w-100" disabled>Simpan Pengaturan</button>
    </form>

    <form action="{{ route('settings.mode') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success w-100">
            {{ $mode->mode == 1 ? 'Pindah ke Jam Pulang' : 'Pindah ke Jam Masuk' }}
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const originalWaktuMasuk = "{{ $mode->waktu_masuk }}";
    const originalWaktuPulang = "{{ $mode->waktu_pulang }}";

    const submitButton = document.getElementById('submitButton');
    const waktuMasukInput = document.getElementById('waktu_masuk');
    const waktuPulangInput = document.getElementById('waktu_pulang');

    // Function to check if the form data has changed
    function checkChanges() {
        // Check if either waktu_masuk or waktu_pulang has changed
        const hasChanges = (waktuMasukInput.value !== originalWaktuMasuk || waktuPulangInput.value !==
            originalWaktuPulang);
        submitButton.disabled = !hasChanges; // Enable/Disable the button based on changes
    }

    // Add event listener to input fields
    waktuMasukInput.addEventListener('input', checkChanges);
    waktuPulangInput.addEventListener('input', checkChanges);

    // Initial check if form values are changed
    checkChanges();
});
</script>

@endsection