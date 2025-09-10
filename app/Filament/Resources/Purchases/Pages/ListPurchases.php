<?php

namespace App\Filament\Resources\Purchases\Pages;

use App\Filament\Resources\Purchases\PurchaseResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPurchases extends ListRecords
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_excel')
                ->label('Export Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(route('export.purchases.excel'))
                ->openUrlInNewTab(),
            Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->url(route('export.purchases.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}
