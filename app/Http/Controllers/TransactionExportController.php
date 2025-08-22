<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Exports\TransactionsPDFExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        
        $filename = 'transaksi-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new TransactionsExport($dateFrom, $dateTo), $filename);
    }
    
    public function exportPDF(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        
        $export = new TransactionsPDFExport($dateFrom, $dateTo);
        
        return $export->download();
    }
}
