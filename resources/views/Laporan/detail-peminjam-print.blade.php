<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman - {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .header p {
            font-size: 12px;
            margin: 3px 0;
        }
        
        .print-date {
            text-align: right;
            margin-bottom: 15px;
            font-size: 11px;
            color: #666;
        }
        
        .section-header {
            background-color: #e8e8e8;
            padding: 8px;
            margin: 15px 0 10px 0;
            font-weight: bold;
            font-size: 13px;
            border-left: 4px solid #333;
        }
        
        .peminjam-info {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }
        
        .peminjam-info p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .peminjam-info strong {
            display: inline-block;
            width: 150px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #f0f0f0;
        }
        
        table th {
            border: 1px solid #999;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            background-color: #e8e8e8;
        }
        
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        table tbody tr:hover {
            background-color: #f5f5f5;
        }
        
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
        }
        
        .status-menunggu {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .status-dipinjam {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-dikembalikan {
            background-color: #d4edda;
            color: #155724;
        }
        
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
        }
        
        .summary-item {
            display: inline-block;
            margin-right: 30px;
            margin-bottom: 5px;
        }
        
        .summary-item strong {
            margin-right: 5px;
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #999;
            padding-top: 15px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
        
        .print-button {
            margin-bottom: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background-color: #0056b3;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 5mm;
            }
            
            .print-button, .no-print {
                display: none;
            }
            
            a {
                color: #000;
                text-decoration: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        <i class="feather icon-printer"></i> Print Laporan Ini
    </button>

    <div class="header">
        <h1>LAPORAN PEMINJAMAN</h1>
        <p>Sistem Manajemen Peminjaman Alat</p>
    </div>

    <div class="print-date">
        <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <div class="section-header">INFORMASI PEMINJAM</div>

    <div class="peminjam-info">
        <p><strong>Nama Peminjam:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email ?? '-' }}</p>
        <p><strong>Nomor HP:</strong> {{ $user->no_hp ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $user->alamat ?? '-' }}</p>
        <p><strong>Peran:</strong> <span class="status status-{{ strtolower($user->role) }}">{{ ucfirst($user->role) }}</span></p>
    </div>

    <div class="section-header">RIWAYAT PEMINJAMAN</div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Alat</th>
                <th style="width: 12%;">Tgl Pinjam</th>
                <th style="width: 12%;">Jatuh Tempo</th>
                <th style="width: 15%;">Tujuan</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 12%;">Petugas</th>
                <th style="width: 12%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($user->peminjaman as $pinjam)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ optional($pinjam->alat)->nama_alat ?? '-' }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                    <td>{{ $pinjam->tujuan ?? '-' }}</td>
                    <td>
                        @if($pinjam->status == 'menunggu')
                            <span class="status status-menunggu">Menunggu</span>
                        @elseif($pinjam->status == 'dipinjam')
                            <span class="status status-dipinjam">Dipinjam</span>
                        @elseif($pinjam->status == 'ditolak')
                            <span class="status status-ditolak">Ditolak</span>
                        @elseif($pinjam->status == 'dikembalikan')
                            <span class="status status-dikembalikan">Dikembalikan</span>
                        @else
                            <span class="status">{{ ucfirst($pinjam->status) }}</span>
                        @endif
                    </td>
                    <td>{{ optional($pinjam->petugas)->name ?? '-' }}</td>
                    <td>{{ $pinjam->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada riwayat peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($user->peminjaman->count() > 0)
        <div class="summary">
            <h4 style="margin-bottom: 10px; font-size: 12px;">RINGKASAN</h4>
            <div class="summary-item">
                <strong>Total Peminjaman:</strong> {{ $user->peminjaman->count() }}
            </div>
            <div class="summary-item">
                <strong>Menunggu:</strong> {{ $user->peminjaman->where('status', 'menunggu')->count() }}
            </div>
            <div class="summary-item">
                <strong>Dipinjam:</strong> {{ $user->peminjaman->where('status', 'dipinjam')->count() }}
            </div>
            <div class="summary-item">
                <strong>Ditolak:</strong> {{ $user->peminjaman->where('status', 'ditolak')->count() }}
            </div>
            <div class="summary-item">
                <strong>Dikembalikan:</strong> {{ $user->peminjaman->where('status', 'dikembalikan')->count() }}
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem Manajemen Peminjaman Alat</p>
        <p>© {{ date('Y') }} - Hak Cipta Terlindungi</p>
    </div>
</body>
</html>
