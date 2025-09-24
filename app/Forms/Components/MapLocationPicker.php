<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class MapLocationPicker extends Field
{
    protected string $view = 'forms.components.map-location-picker';

    protected function setUp(): void
    {
        parent::setUp();

        // ضمان وجود مصفوفة حتى entangle لا يجد null
        $this->default(fn($record) => [
            'latitude' => $record?->latitude ?? 32.5,
            'longitude' => $record?->longitude ?? 36.1,
        ]);
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();

        if (!is_array($state)) {
            $state = ['latitude' => 32.5, 'longitude' => 36.1];
        }

        $lat = isset($state['latitude']) ? floatval($state['latitude']) : 32.5;
        $lng = isset($state['longitude']) ? floatval($state['longitude']) : 36.1;

        $this->getRecord()->fill([
            'latitude' => $lat,
            'longitude' => $lng,
        ])->save();
    }
}
