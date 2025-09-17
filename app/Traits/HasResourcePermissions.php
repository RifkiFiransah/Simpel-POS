<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasResourcePermissions
{
    protected static function getPermissionPrefix(): string
    {
        // Pastikan hanya dipakai di Resource yang punya static::$model
        if (!property_exists(static::class, 'model')) {
            return 'default';
        }

        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;
        $model = app($modelClass);

        return method_exists($model, 'getTable') ? $model->getTable() : 'default';
    }

    protected static function key(string $action): string
    {
        return "{$action}_" . static::getPermissionPrefix();
    }

    // Signature harus sama dengan milik Filament Resource/Page
    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        return static::canViewAny();
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user?->hasPermission(static::key('view')) ?? false;
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        return $user?->hasPermission(static::key('create')) ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        return $user?->hasPermission(static::key('edit')) ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        $user = auth()->user();
        return $user?->hasPermission(static::key('delete')) ?? false;
    }

    public static function canView(Model $record): bool
    {
        return static::canViewAny();
    }
}