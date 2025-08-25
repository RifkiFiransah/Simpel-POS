<div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    <div class="flex items-center gap-3">
        <div class="fi-wi-stats-overview-stat-icon flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10">
            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Export Data Transaksi</h3>
            </div>
            
            <div class="mt-2">
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                    {{ number_format($totalTransactions) }} Transaksi
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Total: Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex gap-2">
            <a href="{{ route('export.transactions.excel') }}" 
               class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors"
               target="_blank">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                Export Excel
            </a>
            
            <a href="{{ route('export.transactions.pdf') }}" 
               class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors"
               target="_blank">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                Export PDF
            </a>
        </div>
        
        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            📊 {{ $lastWeekTransactions }} transaksi minggu ini
        </div>
    </div>
</div>
