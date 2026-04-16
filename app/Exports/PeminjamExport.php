<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithStartRow
{

    public function startRow(): int
    {
        return 3;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->setCellValue('A1', 'Laporan Data Peminjam');

                // merge biar jadi 1 baris panjang
                $event->sheet->mergeCells('A1:E1');

                // styling
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            },
        ];
    }

    public function collection()
    {
        $peminjamList = Peminjaman::select('id_pengguna')
            ->distinct()
            ->pluck('id_pengguna');

        $no = 1;

        return User::whereIn('id', $peminjamList)
            ->withCount('peminjaman')
            ->get()
            ->map(function ($user) use (&$no) {
                return [
                    $no++,
                    $user->name,
                    $user->email,
                    $user->no_hp ?? '-',
                    $user->peminjaman_count,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'Email',
            'No HP',
            'Jumlah Peminjaman',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
