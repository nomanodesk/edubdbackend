<?php

namespace App\Exports;

use App\Models\SmsHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MonthlySmsExport implements FromCollection, WithHeadings
{
    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }

    public function collection()
    {
        $start = Carbon::createFromFormat('Y-m', $this->month)->startOfMonth();
        $end   = Carbon::createFromFormat('Y-m', $this->month)->endOfMonth();

        return SmsHistory::whereBetween('created_at', [$start, $end])
            ->select('phone', 'message', 'status', 'created_at')
            ->get();
    }

    public function headings(): array
    {
        return ['Phone', 'Message', 'Status', 'Date'];
    }
}
