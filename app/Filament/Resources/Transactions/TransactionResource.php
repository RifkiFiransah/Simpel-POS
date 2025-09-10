<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\CreateTransaction;
use App\Filament\Resources\Transactions\Pages\EditTransaction;
use App\Filament\Resources\Transactions\Pages\ListTransactions;
use App\Filament\Resources\Transactions\Pages\ViewTransaction;
use App\Filament\Resources\Transactions\Schemas\TransactionForm;
use App\Filament\Resources\Transactions\Tables\TransactionsTable;
use App\Models\Transaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use UnitEnum;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static ?string $navigationLabel = 'Transactions';

    protected static ?string $modelLabel = 'Transaction';

    protected static ?string $pluralModelLabel = 'Transactions';

    protected static ?string $recordTitleAttribute = 'invoice_number';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionsTable::configure($table);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hitung ulang total biar konsisten
        $total = 0;
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
        }

        $data['total'] = $total;
        $data['change'] = ($data['payment'] ?? 0) - $total;

        // Debug ke log, bukan dd
        Log::info('Transaction create data', $data);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Sama seperti sebelum create, hitung ulang biar aman
        $total = 0;
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
        }

        $data['total'] = $total;
        $data['change'] = ($data['payment'] ?? 0) - $total;

        Log::info('Transaction update data', $data);

        return $data;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'edit' => EditTransaction::route('/{record}/edit'),
            'view' => ViewTransaction::route('/{record}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
