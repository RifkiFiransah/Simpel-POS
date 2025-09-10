<?php

namespace App\Filament\Resources\Abouts\Pages;

use App\Filament\Resources\Abouts\AboutResource;
use App\Models\AboutShop;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAbouts extends ListRecords
{
    protected static string $resource = AboutResource::class;

    protected function getHeaderActions(): array
    {
        $hasAbouts = AboutShop::exists();

        return [
            CreateAction::make()
                ->visible(!$hasAbouts)
                ->label('Set Store Information'),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        if(!AboutShop::exists()) {
            $this->redirect($this->getResource()::getUrl('create'));
        }

        // Redirect to edit page if an AboutShop record exists
        $aboutShop = AboutShop::first();
        if ($aboutShop) {
            $this->redirect(AboutResource::getUrl('edit', ['record' => $aboutShop->id]));
        }
    }
}
