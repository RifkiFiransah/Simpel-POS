<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function ($record) {
                    // Hapus gambar saat record dihapus
                    if ($record->image && Storage::disk('public')->exists($record->image)) {
                        Storage::disk('public')->delete($record->image);
                    }
                }),
            ForceDeleteAction::make()
                ->before(function ($record) {
                    // Hapus gambar saat record dihapus permanen
                    if ($record->image && Storage::disk('public')->exists($record->image)) {
                        Storage::disk('public')->delete($record->image);
                    }
                }),
            RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Produk berhasil diperbarui')
            ->body('Data produk telah berhasil disimpan.');
    }
}
