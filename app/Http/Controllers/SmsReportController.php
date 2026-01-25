<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SmsHistory;
use App\Exports\MonthlySmsExport;
use Maatwebsite\Excel\Facades\Excel;

class SmsReportController extends Controller
{
    public function monthlyReport(Request $request)
{
    $month = $request->input('month', now()->format('Y-m'));

    $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
    $end   = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

    $reports = SmsHistory::whereBetween('created_at', [$start, $end])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    $summary = [
        'total'  => SmsHistory::whereBetween('created_at', [$start, $end])->count(),
        'sent'   => SmsHistory::whereBetween('created_at', [$start, $end])
                        ->where('status', 'sent')->count(),
        'failed' => SmsHistory::whereBetween('created_at', [$start, $end])
                        ->where('status', 'failed')->count(),
        'unregistered' => SmsHistory::whereBetween('created_at', [$start, $end])
                        ->where('status', 'unregistered')->count(),
    ];

    return view('admin.smsReports.monthly', compact(
        'reports',
        'summary',
        'month'
    ));
}
public function exportMonthly(Request $request)
{
    $month = $request->month ?? now()->format('Y-m');

    return Excel::download(
        new MonthlySmsExport($month),
        "sms-report-{$month}.xlsx"
    );
}


}
