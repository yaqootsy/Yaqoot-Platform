@props(['lat', 'lng'])
<div
    x-data="{
        latitude: @js($lat),
        longitude: @js($lng),

        // --- دالة لتهيئة الخريطة ---
        initMap() {
            const initialPosition = { lat: this.latitude, lng: this.longitude };

            // إنشاء الخريطة
            const map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: initialPosition,
                zoom: 12
            });

            // إنشاء العلامة (Marker) وجعلها قابلة للسحب
            const marker = new google.maps.Marker({
                position: initialPosition,
                map: map,
                draggable: true
            });

            // --- هذا هو الجزء الأهم ---
            // عند انتهاء سحب العلامة، قم بتحديث بيانات النموذج مباشرة
            google.maps.event.addListener(marker, 'dragend', () => {
                const newPosition = marker.getPosition();
                
                // استخدم $wire.set لتحديث قيم خطوط الطول والعرض في Filament
                // 'data.latitude' هو المسار الصحيح لبيانات النموذج
                $wire.set('data.latitude', newPosition.lat());
                $wire.set('data.longitude', newPosition.lng());
            });
        }
    }"
    x-init="initMap()"
    wire:ignore
>
    {{-- هذا العنصر هو الذي سيحتوي على الخريطة --}}
    <div id="map-canvas" style="height: 400px; border-radius: 8px;"></div>
</div>

{{-- لا تقم بتضمين سكربت Google Maps هنا، بل في الـ Layout الرئيسي --}}