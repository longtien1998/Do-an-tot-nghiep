<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PaymentExport;
use App\Exports\MusicExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportPayments(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->startOfDay());
        $endDate = $request->input('end_date', now()->endOfDay());

        $fileName = 'payments_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new PaymentExport($startDate, $endDate), $fileName);
    }
    public function exportMusics(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->startOfDay());
        $endDate = $request->input('end_date', now()->endOfDay());

        $fileName = 'musics_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new MusicExport($startDate, $endDate), $fileName);
    }
}
