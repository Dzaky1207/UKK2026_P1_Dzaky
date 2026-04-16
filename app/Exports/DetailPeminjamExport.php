<?php

namespace App\Exports;

use App\Models\Peminjaman;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class DetailPeminjamExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize, WithStartRow
{
    protected $user;

    public function __construct($userId)
    {
        $this->user = User::findOrFail($userId);
    }

    public function startRow(): int
    {
        return 5;
    }

    public function collection()
    {
        $no = 1;

        return Peminjaman::with(['alat', 'pengembalian'])
            ->where('id_pengguna', $this->user->id)
            ->get()
            ->map(function ($p) use (&$no) {
                return [
                    $no++,
                    optional($p->alat)->nama_alat,
                    $p->tanggal_pinjam,
                    $p->tanggal_jatuh_tempo,
                    ucfirst($p->status),
                    optional($p->pengembalian)->tanggal_kembali ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Alat',
            'Tanggal Pinjam',
            'Jatuh Tempo',
            'Status',
            'Tanggal Kembali',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function ($event) {

                // Judul
                $event->sheet->setCellValue('A1', 'LAPORAN DETAIL PEMINJAM');
                $event->sheet->mergeCells('A1:F1');

                // Info user
                $event->sheet->setCellValue('A2', 'Nama');
                $event->sheet->setCellValue('B2', ': ' . $this->user->name);

                $event->sheet->setCellValue('A3', 'Email');
                $event->sheet->setCellValue('B3', ': ' . $this->user->email);

                // Styling judul
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header tabel di row 5
        $sheet->getStyle('A5:F5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0D6EFD'],
            ],
        ]);

        // Border tabel
        $sheet->getStyle('A5:F100')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }
}