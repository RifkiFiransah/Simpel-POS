<?php

namespace App\Http\Controllers;

use App\Exports\SimpleTransactionsExport;
use App\Exports\TransactionsPDFExport;
use App\Exports\ProductsExport;
use App\Exports\CustomersExport;
use App\Exports\SuppliersExport;
use App\Exports\CategoriesExport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransactionExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        // Increase memory limit untuk export
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $invoice = $request->get('invoice'); // Single invoice export
        
        // Tentukan nama file berdasarkan filter
        $filename = 'transaksi-';
        if ($invoice) {
            $filename .= $invoice . '-';
        } elseif ($dateFrom && $dateTo) {
            $filename .= $dateFrom . '-to-' . $dateTo . '-';
        } else {
            $filename .= 'all-data-';
        }
        $filename .= now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new SimpleTransactionsExport($dateFrom, $dateTo, $invoice), $filename);
    }
    
    public function exportPDF(Request $request)
    {
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $invoice = $request->get('invoice');
        
        $export = new TransactionsPDFExport($dateFrom, $dateTo, $invoice);
        
        return $export->download();
    }
    
    public function exportProductsExcel()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        
        $filename = 'data-produk-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new ProductsExport(), $filename);
    }
    
    public function exportCustomersExcel()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        
        $filename = 'data-customer-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new CustomersExport(), $filename);
    }
    
    public function exportSuppliersExcel()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        
        $filename = 'data-supplier-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new SuppliersExport(), $filename);
    }
    
    public function exportCategoriesExcel()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        
        $filename = 'data-kategori-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new CategoriesExport(), $filename);
    }
    
    public function exportUsersExcel()
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        
        $filename = 'data-user-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new UsersExport(), $filename);
    }
}
