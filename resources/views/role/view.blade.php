<?php
````php
````php
<div class="space-y-6">
    <!-- Role Info -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Role</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Tampilan:</span>
                <p class="text-gray-900 dark:text-white">{{ $record->display_name }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Sistem:</span>
                <p class="text-gray-900 dark:text-white">{{ $record->name }}</p>
            </div>
            <div class="col-span-2">
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi:</span>
                <p class="text-gray-900 dark:text-white">{{ $record->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah User:</span>
                <p class="text-gray-900 dark:text-white">{{ $record->users()->count() }} user</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Hak Akses:</span>
                <p class="text-gray-900 dark:text-white">{{ count($record->permissions ?? []) }} permission</p>
            </div>
        </div>
    </div>

    <!-- Permissions by Group -->
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hak Akses yang Dimiliki</h3>
        
        @php
            $groupedPermissions = $record->getPermissionsByGroup();
        @endphp
        
        @if(empty($groupedPermissions))
            <p class="text-gray-500 dark:text-gray-400 italic">Role ini belum memiliki hak akses apapun.</p>
        @else
            <div class="space-y-4">
                @foreach($groupedPermissions as $group => $permissions)
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ $group }}</h4>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($permissions as $key => $label)
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Users with this Role -->
    @if($record->users()->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">User dengan Role Ini</h3>
            <div class="space-y-2">
                @foreach($record->users as $user)
                    <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded">
                        <div>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">{{ $user->email }}</span>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>