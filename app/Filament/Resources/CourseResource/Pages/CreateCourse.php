<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

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
                    ->url(CourseResource::getUrl('view', ['record' => $entity->id])),

                Action::make('Edit')
                    ->label('Edit Record')
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->url(CourseResource::getUrl('edit', ['record' => $entity->id])),
            ])
            ->sendToDatabase(User::find($entity->user_id));
    }
}
