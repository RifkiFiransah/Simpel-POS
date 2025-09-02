<?php

namespace App\Filament\Resources\Purchases\Pages;

use App\Filament\Resources\Purchases\PurchaseResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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

        Log::info('Purchase create data', $data);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Setelah record dan items tersimpan, hitung ulang total
        $this->record->calculateTotal();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
