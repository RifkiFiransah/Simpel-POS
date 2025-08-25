<?php

namespace App\Filament\Resources\Exports\Schemas;

use Filament\Schemas\Schema;

class ExportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
