<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Peminjam</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            margin: 2px 0;
        }
        
        .print-date {
            text-align: right;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #f5f5f5;
        }
        
        table th {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #e8e8e8;
            padding: 5px;
            border-left: 3px solid #333;
        }
        
        .detail-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        .peminjam-name {
            font-weight: bold;
            font-size: 12px;
        }
        
        .peminjam-info {
            font-size: 10px;
            color: #666;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 5mm;
            }
            
            .detail-section {
                page-break-inside: avoid;
            }
            
            a {
                color: #000;
                text-decoration: none;
            }
            
            button, .no-print {
                display: none;
            }
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #999;
            padding-top: 10px;
            font-size: 10px;
            text-align: center;
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
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">
        <i class="feather icon-printer"></i> Print
    </button>

    <div class="header">
        <h1>LAPORAN DATA PEMINJAM</h1>
        <p>Sistem Manajemen Peminjaman Alat</p>
    </div>

    <div class="print-date">
        <p>Tanggal Cetak: {{ date('d-m-Y H:i:s') }}</p>
    </div>

    <div class="section-title">DAFTAR PEMINJAM YANG MELAKUKAN PEMINJAMAN</div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Peminjam</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;">No. HP</th>
                <th style="width: 15%;">Alamat</th>
                <th style="width: 10%;">Jml Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjams as $peminjam)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="peminjam-name">{{ $peminjam->name }}</td>
                    <td>{{ $peminjam->email ?? '-' }}</td>
                    <td>{{ $peminjam->no_hp ?? '-' }}</td>
                    <td>{{ $peminjam->alamat ?? '-' }}</td>
                    <td style="text-align: center;">{{ $peminjam->peminjaman->count() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada data peminjam</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">DETAIL PEMINJAMAN SETIAP PEMINJAM</div>

    @forelse ($peminjams as $peminjam)
        <div class="detail-section">
            <h3 style="margin-bottom: 10px; color: #333;">{{ $peminjam->name }}</h3>
            <div class="peminjam-info" style="margin-bottom: 10px;">
                <p><strong>Email:</strong> {{ $peminjam->email ?? '-' }}</p>
                <p><strong>No. HP:</strong> {{ $peminjam->no_hp ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $peminjam->alamat ?? '-' }}</p>
            </div>
            
            <table style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Alat</th>
                        <th style="width: 15%;">Tanggal Pinjam</th>
                        <th style="width: 15%;">Jatuh Tempo</th>
                        <th style="width: 15%;">Tujuan</th>
                        <th style="width: 15%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjam->peminjaman as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($item->alat)->nama_alat ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
                            <td>{{ $item->tujuan ?? '-' }}</td>
                            <td>
                                @if($item->status == 'menunggu')
                                    <span>Menunggu</span>
                                @elseif($item->status == 'dipinjam')
                                    <span>Dipinjam</span>
                                @elseif($item->status == 'ditolak')
                                    <span>Ditolak</span>
                                @elseif($item->status == 'dikembalikan')
                                    <span>Dikembalikan</span>
                                @else
                                    {{ $item->status }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Tidak ada peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @empty
        <p style="text-align: center;">Belum ada data peminjam</p>
    @endforelse

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem Manajemen Peminjaman Alat</p>
        <p>{{ config('app.name') }} © {{ date('Y') }}</p>
    </div>
</body>
</html>
