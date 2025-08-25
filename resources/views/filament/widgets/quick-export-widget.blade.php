<div class="fi-wi-widget rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            ⚡ Quick Export Actions
        </h3>
        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
            </svg>
            <span>Export Center</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-5 gap-3 mb-6">
        <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
            <div class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['total']) }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Total</div>
        </div>
        <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
            <div class="text-xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['today']) }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Hari Ini</div>
        </div>
        <div class="text-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
            <div class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ number_format($stats['week']) }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Minggu</div>
        </div>
        <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
            <div class="text-xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($stats['month']) }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Bulan</div>
        </div>
        <div class="text-center p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
            <div class="text-sm font-bold text-red-600 dark:text-red-400">Rp {{ number_format($stats['revenue']/1000, 0) }}K</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Revenue</div>
        </div>
    </div>

    <!-- Export Sections -->
    <div class="space-y-6">
        <!-- Transaction Exports -->
        <div>
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Export Transaksi
            </h4>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Excel All Data -->
                <a href="{{ route('export.transactions.excel') }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">Excel All</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Semua Data</span>
                </a>

                <!-- PDF All Data -->
                <a href="{{ route('export.transactions.pdf') }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">PDF All</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Semua Data</span>
                </a>

                <!-- Excel Monthly -->
                <a href="{{ route('export.transactions.excel', ['date_from' => now()->startOfMonth()->format('Y-m-d'), 'date_to' => now()->endOfMonth()->format('Y-m-d')]) }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">Bulan Ini</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Excel</span>
                </a>

                <!-- Excel Weekly -->
                <a href="{{ route('export.transactions.excel', ['date_from' => now()->startOfWeek()->format('Y-m-d'), 'date_to' => now()->endOfWeek()->format('Y-m-d')]) }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 dark:bg-yellow-900/20 dark:hover:bg-yellow-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">Minggu Ini</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Excel</span>
                </a>
            </div>
        </div>

        <!-- Master Data Exports -->
        <div>
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14m-14 0a2 2 0 012 2v2a2 2 0 01-2 2m0 0h14a2 2 0 002-2v-2a2 2 0 00-2-2"></path>
                </svg>
                Export Data Master
            </h4>
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Products Export -->
                <a href="{{ route('export.products.excel') }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 dark:bg-orange-900/20 dark:hover:bg-orange-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">Produk</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Excel</span>
                </a>

                <!-- Customers Export -->
                <a href="{{ route('export.customers.excel') }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">Customer</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Excel</span>
                </a>

                <!-- Suppliers Export -->
                <a href="{{ route('export.suppliers.excel') }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">Supplier</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Excel</span>
                </a>

                <!-- Categories Export -->
                <a href="{{ route('export.categories.excel') }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 dark:bg-yellow-900/20 dark:hover:bg-yellow-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">Kategori</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Excel</span>
                </a>

                <!-- Users Export -->
                <a href="{{ route('export.users.excel') }}" 
                   target="_blank"
                   class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 rounded-lg transition-colors group">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white text-center">User</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Excel</span>
                </a>
            </div>
        </div>
    </div>    <!-- Quick Tips -->
    <div class="mt-6 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
        <div class="flex items-start space-x-2">
            <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <strong>Quick Tip:</strong> Klik button untuk export langsung, atau buka halaman Transactions untuk export dengan filter custom.
            </div>
        </div>
    </div>
</div>
