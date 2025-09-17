<?php

namespace App\Filament\Resources\Exports;

use App\Filament\Resources\Exports\Pages\ListExports;
use App\Models\Transaction;
use App\Traits\HasResourcePermissions;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;
use UnitEnum;

class ExportResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Transaction::class;

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static ?string $navigationLabel = 'Quick Export';
    
    protected static ?string $modelLabel = 'Export';
    
    protected static ?string $pluralModelLabel = 'Export Data';
    
    protected static ?int $navigationSort = 7;

    // Define permission prefix for this resource
    protected static function getPermissionPrefix(): string
    {
        return 'exports';
    }

    // Hide navigation if user doesn't have view permission
    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->query(Transaction::query()->limit(0)) // Empty query for quick actions
            ->columns([])
            ->toolbarActions([])
            ->emptyStateIcon('heroicon-o-arrow-down-tray')
            ->emptyStateHeading('Quick Export Actions')
            ->emptyStateDescription('Pilih format export yang diinginkan')
            ->emptyStateActions([
                Action::make('export_excel_all')
                    ->label('📊 Export All Data (Excel)')
                    ->icon('heroicon-m-document-arrow-down')
                    ->color('success')
                    ->url(fn () => route('export.transactions.excel'))
                    ->openUrlInNewTab(),

                Action::make('export_pdf_all')
                    ->label('📄 Export All Data (PDF)')
                    ->icon('heroicon-m-document-text')
                    ->color('danger')
                    ->url(fn () => route('export.transactions.pdf'))
                    ->openUrlInNewTab(),

                Action::make('export_excel_month')
                    ->label('📅 Export This Month (Excel)')
                    ->icon('heroicon-m-calendar')
                    ->color('info')
                    ->url(fn () => route('export.transactions.excel', [
                        'date_from' => now()->startOfMonth()->format('Y-m-d'),
                        'date_to' => now()->endOfMonth()->format('Y-m-d')
                    ]))
                    ->openUrlInNewTab(),

                Action::make('export_excel_week')
                    ->label('📈 Export This Week (Excel)')
                    ->icon('heroicon-m-chart-bar')
                    ->color('warning')
                    ->url(fn () => route('export.transactions.excel', [
                        'date_from' => now()->startOfWeek()->format('Y-m-d'),
                        'date_to' => now()->endOfWeek()->format('Y-m-d')
                    ]))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExports::route('/'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function canEdit($record): bool
    {
        return false;
    }
    
    public static function canDelete($record): bool
    {
        return false;
    }
    
    public static function canView($record): bool
    {
        return false;
    }
}
