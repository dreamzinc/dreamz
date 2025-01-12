<?php

namespace App\Filament\Resources\PromotionResource\Pages;

use App\Filament\Resources\PromotionResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePromotion extends CreateRecord
{
    protected static string $resource = PromotionResource::class;

    public function afterCreate(): void
    {
        $entity = $this->record;
        Notification::make()
            ->title("🎉 {$entity->code} Created Successfully!")
            ->icon('heroicon-o-check-circle')
            ->body("A new {$entity->code} has been added to the system.")
            ->actions([
                Action::make('View')
                    ->label('View Details')
                    ->color('primary')
                    ->icon('heroicon-o-eye')
                    ->url(PromotionResource::getUrl('view', ['record' => $entity->id])),

                Action::make('Edit')
                    ->label('Edit Record')
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->url(PromotionResource::getUrl('edit', ['record' => $entity->id])),
            ])
            ->sendToDatabase(User::find($entity->user_id));
    }
}
