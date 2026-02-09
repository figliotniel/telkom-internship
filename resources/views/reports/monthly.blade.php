<!DOCTYPE html>
<html>
<head>
    <title>Laporan Magang {{ $month }}/{{ $year }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .no-print { margin-bottom: 20px; padding: 10px; background: #eee; text-align: center;}
        .btn { padding: 5px 15px; background: #333; color: #fff; text-decoration: none; border-radius: 4px; cursor: pointer;}
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <h2 style="margin:0;">Laporan Aktivitas & Kehadiran Magang</h2>
        <h3 style="margin:5px 0;">Telkom Indonesia</h3>
        <p>Bulan: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</p>
        <p>Nama: {{ Auth::user()->name }} | Divisi: {{ $internship->division->name ?? '-' }}</p>
    </div>

    <h3>A. Kehadiran</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $a)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }}</td>
                <td>{{ $a->check_in_time ?? '-' }}</td>
                <td>{{ $a->check_out_time ?? '-' }}</td>
                <td>
                    {{ ucfirst($a->status) }}
                    @if($a->permit_type)
                        <br><small>({{ $a->permit_type == 'full' ? 'Izin Penuh' : 'Izin Setengah Hari' }})</small>
                    @endif
                </td>
                <td>{{ $a->note }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center">Tidak ada data kehadiran bulan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>B. Logbook Harian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbooks as $index => $log)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}</td>
                <td>{{ $log->activity }}</td>
                <td>{{ ucfirst($log->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center">Tidak ada logbook bulan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 50px; display: flex; justify-content: space-between;">
        <div style="text-align: center; width: 200px;">
            <p>Mengetahui,</p>
            <p>Mentor Pembimbing</p>
            <br><br><br>
            <p>(...................................)</p>
        </div>
        <div style="text-align: center; width: 200px;">
            <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Mahasiswa Pemagang</p>
            <br><br><br>
            <p>{{ Auth::user()->name }}</p>
        </div>
    </div>
</body>
</html>
