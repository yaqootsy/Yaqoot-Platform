<?php

namespace App\Livewire;

use Livewire\Component;

class GoogleMapField extends Component
{
    // Make properties nullable
    public ?float $latitude;
    public ?float $longitude;

    public function mount(?float $latitude, ?float $longitude)
    {
        $this->latitude = $latitude ?? 32.5;
        $this->longitude = $longitude ?? 36.1;
    }

    public function render()
    {
        return view('livewire.google-map-field');
    }

    // ✅ أضف هذه الطريقة
    // تقوم بتحديث خصائص النموذج الأب
    public function updateCoordinates($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
        // قم بإرسال حدث لنموذج Filament لتحديث البيانات
        $this->dispatch('update-coordinates', latitude: $this->latitude, longitude: $this->longitude);
    }
}
