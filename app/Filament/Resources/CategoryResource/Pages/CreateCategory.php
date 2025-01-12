<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    public function afterCreate(): void
    {
        $entity = $this->record;
        Notification::make()
            ->title("🎉 {$entity->name} Created Successfully!")
            ->icon('heroicon-o-check-circle')
            ->body("A new {$entity->name} with description '{$entity->description}' has been added to the system.")
            ->actions([
                Action::make('View')
                    ->label('View Details')
                    ->color('primary')
                    ->icon('heroicon-o-eye')
                    ->url(CategoryResource::getUrl('view', ['record' => $entity->id])),

                Action::make('Edit')
                    ->label('Edit Record')
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->url(CategoryResource::getUrl('edit', ['record' => $entity->id])),
            ])
            ->sendToDatabase(User::find(Filament::auth()->id()));
    }
}
