<?php

namespace App\Exports;

use App\ClassGroup;
use App\Teacher;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PresencesExport implements FromView, ShouldAutoSize, WithEvents, WithColumnFormatting
{
    public $id;
    public $month;

    public function __construct($id, $month)
    {
        $this->id = $id;
        $this->month = $month;
    }

    public function view(): View
    {
        $class = ClassGroup::find($this->id);
        $month = $this->getMonth($this->month);
        $headmaster = Teacher::where('position_id', 1)->first();
        $teacher = Teacher::where('homeroom_teacher_of', $this->id)->first();
        $monthIndex = $this->month;
        return view('admin.export.presenceExcel', [
            'class' => $class,
            'month' => $month,
            'headmaster' => $headmaster,
            'teacher' => $teacher,
            'monthIndex' => $monthIndex,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $end_col = null;
                switch (cal_days_in_month(CAL_GREGORIAN, $this->month, date('Y'))) {
                    case '28':
                        $end_col = 'AG';
                        $start_total = 'AH';
                        $end_total = 'AK';
                        $start_signature = 'AC';
                        $end_signature = 'AJ';
                        break;
                    case '29':
                        $end_col = 'AH';
                        $start_total = 'AI';
                        $end_total = 'AL';
                        $start_signature = 'AD';
                        $end_signature = 'AK';
                        break;
                    case '30':
                        $end_col = 'AI';
                        $start_total = 'AJ';
                        $end_total = 'AM';
                        $start_signature = 'AE';
                        $end_signature = 'AL';
                        break;
                    default:
                        $end_col = 'AJ';
                        $start_total = 'AK';
                        $end_total = 'AN';
                        $start_signature = 'AF';
                        $end_signature = 'AM';
                        break;
                }
                $end_row = ClassGroup::find($this->id)->students()->count() + 7;

                // Vertical Alignment
                $verticalAlignment = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('A1:' . $end_total . ($end_row + 9))->applyFromArray($verticalAlignment);

                // Align Left
                $alignLeft = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ];
                $event->sheet->getDelegate()->getStyle('B8:' . 'D' . $end_row)->applyFromArray($alignLeft);

                // All Border
                $borderStyle = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ]
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('A5:A7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('B5:B7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('C5:C7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('D5:D7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('D5:D7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('E5:E7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('F5:' . $end_col . '5')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('F6:' . $end_col . '6')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('F7:' . $end_col . '7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('A8:' . 'A' . $end_row)->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('B8:' . 'B' . $end_row)->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('C8:' . 'C' . $end_row)->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('D8:' . 'D' . $end_row)->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('E8:' . 'E' . $end_row)->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('E8:' . 'E' . $end_row)->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('F8:' . $end_col . $end_row)->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle($start_total . '5:' . $end_total . '6')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle($start_total . '7:' . $end_total . '7')->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle($start_total . '8:' . $end_total . ($end_row + 1))->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('A' . ($end_row + 1) . ':E' . ($end_row + 1))->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle('A' . ($end_row + 1) . ':' . $end_total . ($end_row + 1))->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle($end_total . '7:' . $end_total . ($end_row + 1))->applyFromArray($borderStyle);

                // Border Bottom
                $borderStyle = [
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ]
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('B' . ($end_row + 8) . ':C' . ($end_row + 8))->applyFromArray($borderStyle);
                $event->sheet->getDelegate()->getStyle($start_signature . ($end_row + 8) . ':' . $end_signature . ($end_row + 8))->applyFromArray($borderStyle);
            },
        ];
    }

    private function getMonth($month)
    {
        switch ($month) {
            case '01':
                return 'Januari';
                break;
            case '02':
                return 'Februari';
                break;
            case '03':
                return 'Maret';
                break;
            case '04':
                return 'April';
                break;
            case '05':
                return 'Mei';
                break;
            case '06':
                return 'Juni';
                break;
            case '07':
                return 'Juli';
                break;
            case '08':
                return 'Agustus';
                break;
            case '09':
                return 'September';
                break;
            case '10':
                return 'Oktober';
                break;
            case '11':
                return 'November';
                break;
            default:
                return 'Desember';
                break;
        }
    }
}
