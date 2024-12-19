<!DOCTYPE html>
<html>

<head>
    <title>Data Absensi</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }
    </style>
</head>

<body>
    <h1>Data Absensi</h1>
    <table>
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
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->uid }}</td>
                <td>{{ $item->Karyawan ? $item->Karyawan->nama : 'Karyawan Dihapus' }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->jam_masuk }}</td>
                <td>{{ $item->jam_pulang }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>