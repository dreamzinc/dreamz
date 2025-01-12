<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function afterCreate(): void
    {
        $entity = $this->record;
        Notification::make()
            ->title("🎉 {$entity->name} Created Successfully!")
            ->icon('heroicon-o-check-circle')
            ->body("A new {$entity->name} with email '{$entity->email}' has been added to the system.")
            ->actions([
                Action::make('Edit')
                    ->label('Edit Record')
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->url(UserResource::getUrl('edit', ['record' => $entity->id])),
            ])
            ->sendToDatabase(User::find(Filament::auth()->id()));
    }
}
