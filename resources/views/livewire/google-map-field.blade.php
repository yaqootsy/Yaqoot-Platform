<div>
    <div id="map" wire:ignore style="height: 400px; width: 100%;"></div>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANWPf72r_A0rSYpmnXJ_1J4MRIhCswK0c&libraries=places&callback=initMap"></script>

    <script>
        function initMap() {
            const mapDiv = document.getElementById('map');
            if (!mapDiv) {
                return;
            }

            const map = new google.maps.Map(mapDiv, {
                center: {
                    lat: @js($latitude),
                    lng: @js($longitude)
                },
                zoom: 10
            });

            const marker = new google.maps.Marker({
                position: {
                    lat: @js($latitude),
                    lng: @js($longitude)
                },
                map: map,
                draggable: true
            });

            marker.addListener('dragend', function() {
                const position = marker.getPosition();

                // ✅ استدعي الطريقة الجديدة في الكومبوننت
                @this.call('updateCoordinates', position.lat(), position.lng());
            });
        }
    </script>
</div>
