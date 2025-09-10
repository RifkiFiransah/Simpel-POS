<?php

namespace App\Filament\Resources\Purchases\Pages;

use App\Filament\Resources\Purchases\PurchaseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EditPurchase extends EditRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    // protected function handleRecordUpdate(Model $record, array $data): Model
    // {
    //     // Calculate total from items
    //     $total = 0;
    //     if (isset($data['items']) && is_array($data['items'])) {
    //         foreach ($data['items'] as $item) {
    //             $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
    //         }
    //     }

    //     // Set calculated values
    //     $data['total'] = $total;
    //     $data['change'] = ($data['payment'] ?? 0) - $total;

    //     // Remove items from main data as they will be handled by relationship
    //     $items = $data['items'] ?? [];
    //     unset($data['items']);

    //     // Update purchase
    //     $record->update($data);

    //     // Update purchase items
    //     foreach ($items as $item) {
    //         $item['purchase_id'] = $record->id;
    //         $item['subtotal'] = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
    //         $record->items()->updateOrCreate(['id' => $item['id']], $item);
    //     }

    //     return $record;
    // }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Hitung total dari items
        $total = 0;
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
        }

        $data['total'] = $total;
        $data['change'] = ($data['payment'] ?? 0) - $total;

        Log::info('Purchase update data', $data);

        return $data;
    }

    protected function afterSave(): void
    {
        // Setelah record dan items tersimpan, hitung ulang total
        $this->record->refresh();
        $this->record->calculateTotal();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
