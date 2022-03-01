<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use stdClass;

use function Complex\add;

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle,
WithStyles
{

    protected $userId, $dateFrom, $dateTo, $reportType;

    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;

    }

    public function collection()
    {
        $data = [];

        if ($this->reportType == 1) {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->userId == 0) {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                            ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'sales.created_at', 'u.name as user')
                            ->whereBetween('sales.created_at', [$from, $to])
                            ->get();
        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                            ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'sales.created_at', 'u.name as user')
                            ->whereBetween('sales.created_at', [$from, $to])
                            ->where('user_id', $this->userId)
                            ->get();
        }

        return $data;

    }

    //Titulos

    public function headings() :array
    {
        return ["FOLIO", "IMPORTE", "ITEMS", "ESTADO", "FECHA", "USUARIO"];
    }

    public function startCell(): string
    {
        return 'A2';
    }


    public function styles(Worksheet $sheet)
    {
        return [
            //El dos representa la fila donde esta el estilo
            2 => ['font' => ['bold' => true]],
            'B' => [NumberFormat::FORMAT_DATE_DDMMYYYY,],
        ];
    }

    public function title(): string
    {
        return 'Reporte de Ventas';
    }

}
