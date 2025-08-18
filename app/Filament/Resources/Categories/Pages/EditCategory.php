<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function ($record) {
                    if ($record->image && Storage::disk('public')->exists($record->image)) {
                        Storage::disk('public')->delete($record->image);
                    }
                }),
            ForceDeleteAction::make()
                ->before(function ($record) {
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
            ->title('Kategori Berhasil Diperbarui')
            ->success()
            ->body('Data Kategori telah berhasil diperbarui.');
    }
}
