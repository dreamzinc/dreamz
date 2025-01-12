<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    public function afterCreate(): void
    {
        $entity = $this->record;
        Notification::make()
            ->title("🎉 {$entity->title} Created Successfully!")
            ->icon('heroicon-o-check-circle')
            ->body("A new {$entity->title} with description '{$entity->description}' has been added to the system.")
            ->actions([
                Action::make('View')
                    ->label('View Details')
                    ->color('primary')
                    ->icon('heroicon-o-eye')
                    ->url(ServiceResource::getUrl('view', ['record' => $entity->id])),

                Action::make('Edit')
                    ->label('Edit Record')
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->url(ServiceResource::getUrl('edit', ['record' => $entity->id])),
            ])
            ->sendToDatabase(User::find($entity->user_id));
    }
}
