<div class="p-6">
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($totalTransactions) }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Transaksi</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Pendapatan</p>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($thisMonth) }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Bulan Ini</p>
                </div>
            </div>
        </div>

        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($thisWeek) }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Minggu Ini</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📊 Export Options</h4>
        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
            <p>• <strong>Excel Format:</strong> Ideal untuk analisis data dan spreadsheet</p>
            <p>• <strong>PDF Format:</strong> Cocok untuk laporan formal dan presentasi</p>
            <p>• <strong>Filter by Date:</strong> Gunakan parameter date_from dan date_to</p>
            <p>• <strong>Single Transaction:</strong> Export berdasarkan invoice tertentu</p>
        </div>
    </div>
</div>
