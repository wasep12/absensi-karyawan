@if($hasil == 1)
	@if(request()->is('halaman-spesifik'))
		<link rel="preload" as="image" href="{{ url('/assets_admin/img/scan/rfid.gif') }}">
		<link rel="preload" as="image" href="{{ url('/assets_admin/img/scan/loading.gif') }}">
	@endif

	<center>
		<h3>Silahkan Tempelkan Kartu Anda Pada RFID Reader</h3>
		<h4>Mode Absensi : <span style="font-weight: bold;">{{$text_mode}}</span></h4>
		<img src="{{ url('/assets_admin/img/scan/rfid.gif') }}" width="400" class="d-block" loading="lazy">
		<img src="{{ url('/assets_admin/img/scan/loading.gif') }}" width="500" style="margin-top: -93px;" loading="lazy">
	</center>
@elseif($hasil == 0)
	<center>
		<h3>Kamu Berhasil Absen Masuk </h3>
		<h3>Selamat Datang {{$nama}}</h3>
		<h4>Semoga Harimu Menyenangkan</h4>
	</center>
@elseif($hasil == 2)
	<center>
		<h3>Kamu Berhasil Absen Pulang </h3>
		<h3>Selamat Jalan {{$nama}}</h3>
		<h4>Semoga Selamat Sampai Tujuan</h4>
	</center>
@elseif($hasil == 3)
	<center>
		<h3 style="color: red;">MAAF KARTU BELUM TERDAFTAR !!!!!</h3>
	</center>
@elseif($hasil == 4)
	<center>
		<h3 style="color: red;">BELUM WAKTUNYA PULANG !!!!!</h3>
	</center>
@endif