<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Calculate total from items
        $total = 0;
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            }
        }
        
        // Set calculated values
        $data['total'] = $total;
        $data['change'] = ($data['payment'] ?? 0) - $total;
        
        // Remove items from main data as they will be handled by relationship
        $items = $data['items'] ?? [];
        unset($data['items']);
        
        // Create transaction
        $record = static::getModel()::create($data);
        
        // Create transaction items
        foreach ($items as $item) {
            $item['transaction_id'] = $record->id;
            $item['subtotal'] = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            $record->items()->create($item);
        }
        
        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
