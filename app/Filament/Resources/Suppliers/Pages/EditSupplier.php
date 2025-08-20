<?php

namespace App\Filament\Resources\Suppliers\Pages;

use App\Filament\Resources\Suppliers\SupplierResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditSupplier extends EditRecord
{
    protected static string $resource = SupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function ($record) {
                    if($record->image && Storage::disk('public')->exists($record->image)) {
                        Storage::disk('public')->delete($record->image);
                    }
                }),
            ForceDeleteAction::make()
                ->before(function ($record) {
                    if($record->image && Storage::disk('public')->exists($record->image)) {
                        Storage::disk('public')->delete($record->image);
                    }
                }),
            RestoreAction::make(),
        ];
    }

    // protected function getRedirectUrl(): ?string
    // {
    //     return $this->getResourceUrl()::getUrl('index');
    // }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Supplier berhasil diperbarui')
            ->body('Supplier telah berhasil diperbarui.')
            ->success();
    }
}
