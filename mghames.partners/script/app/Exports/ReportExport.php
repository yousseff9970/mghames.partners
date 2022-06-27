<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportExport implements
    FromCollection,
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents
{
    use Exportable;

    public function collection()
    {
        $data = Order::with('plan','getway','user')->get();
        return $data;
    }

    public function map($data): array
    {
        return [
            $data->plan['name'] ?? null,
            $data->getway['name'] ?? null,
            $data->user['email'] ?? null,
            number_format($data->price ?? 0,2),
            number_format($data->tax ?? 0,2),
            $data->will_expire ?? null,
            $data->trx ?? null,
            $data->payment_status==1 ? 'complete':'pending',
            $data->status==1 ? 'Active':'Deactive',
            $data->created_at->format('d.m.Y'),
        ];
    }
    public function headings(): array
    {
        return [
            "Plan Name",
            "Gateway Name",
            "User Email",
            "Price",
            "Tax",
            "Exp Date",
            "Trx",
            "Status",
            "Created Date",
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:M1')->applyFromArray([
                    'font'      => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders'   => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill'      => [
                        'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation'   => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor'   => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],

                ]);
            },
        ];
    }
}
