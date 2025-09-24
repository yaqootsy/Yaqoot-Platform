<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :state-path="$getStatePath()">

    @php
        $state = $getState() ?? [];
        $initialLat = $state['latitude'] ?? 32.5;
        $initialLng = $state['longitude'] ?? 36.1;
    @endphp

    <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') ?? env('GOOGLE_MAPS_KEY') }}&libraries=places&callback=googleMapsInit"></script>

    <div x-data="mapPicker({{ json_encode($initialLat) }}, {{ json_encode($initialLng) }})" x-init="init()" x-cloak>
        {{-- container --}}
        <div x-ref="mapDiv" style="height: 400px; width: 100%; display: block;"></div>

    </div>

    <script>
        function googleMapsInit() {
            console.log('✅ Google Maps API Loaded');
            document.dispatchEvent(new CustomEvent('google-maps-loaded'));
        }

        function mapPicker(initialLat = 32.5, initialLng = 36.1) {
            return {
                map: null,
                marker: null,
                latitude: parseFloat(initialLat),
                longitude: parseFloat(initialLng),
                initialized: false,
                visibilityObserver: null,

                init() {
                    console.log('[mapPicker] init');

                    // تأكد أن العنصر له ارتفاع واضح (حماية)
                    if (this.$refs.mapDiv) {
                        this.$refs.mapDiv.style.minHeight = this.$refs.mapDiv.style.minHeight || '400px';
                        this.$refs.mapDiv.style.display = 'block';
                    }

                    // إذا Google جاهزة فحاول تهيئة، وإلا انتظر الحدث
                    const tryInit = () => {
                        if (typeof google !== 'undefined' && google.maps) {
                            // نستعمل مراقب الرؤية حتى نضمن الظهور (مفيد داخل تبويبات/مودالات)
                            this.setupVisibilityObserver();
                        } else {
                            console.log('[mapPicker] waiting google-maps-loaded event');
                            window.addEventListener('google-maps-loaded', () => {
                                this.setupVisibilityObserver();
                            }, {
                                once: true
                            });
                        }
                    };

                    tryInit();
                },

                setupVisibilityObserver() {
                    // إذا العنصر مرئي الآن فابدأ initMap فوراً
                    const el = this.$refs.mapDiv;
                    if (!el) return;

                    const isVisibleNow = el.offsetParent !== null && el.getBoundingClientRect().height > 0;
                    if (isVisibleNow) {
                        this.initMap();
                        return;
                    }

                    // خلاف ذلك، راقب متى يصبح العنصر مرئيًا
                    if ('IntersectionObserver' in window) {
                        this.visibilityObserver = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    if (!this.initialized) {
                                        this.initMap();
                                    } else {
                                        // لو تم تهيئة الخريطة سابقاً: ننفّذ resize ونعيد المركز
                                        google.maps.event.trigger(this.map, 'resize');
                                        this.map.setCenter({
                                            lat: this.latitude,
                                            lng: this.longitude
                                        });
                                    }
                                }
                            });
                        }, {
                            threshold: 0.01
                        });

                        this.visibilityObserver.observe(el);
                        console.log('[mapPicker] IntersectionObserver created, waiting for visibility');
                        return;
                    }

                    // كخيار احتياطي: محاولة بعد تأخير
                    setTimeout(() => {
                        if (!this.initialized) this.initMap();
                    }, 250);
                },

                initMap() {
                    if (this.initialized) return;
                    if (!this.$refs.mapDiv) return console.warn('mapDiv not found');

                    console.log('[mapPicker] initMap running — center:', this.latitude, this.longitude);

                    const center = {
                        lat: parseFloat(this.latitude) || 32.5,
                        lng: parseFloat(this.longitude) || 36.1
                    };

                    // إنشـاء الخريطة
                    this.map = new google.maps.Map(this.$refs.mapDiv, {
                        center,
                        zoom: 12,
                        // أي إعدادات إضافية ...
                    });

                    // Marker (يمكن تغييره لاحقًا إلى AdvancedMarkerElement عند اللزوم)
                    this.marker = new google.maps.Marker({
                        position: center,
                        map: this.map,
                        draggable: true,
                    });

                    // عند سحب الماركر: حدّث محليًا وادفع للسيرفر (كما سبق قمنا)
                    this.marker.addListener('dragend', () => {
                        const pos = this.marker.getPosition();
                        this.latitude = parseFloat(pos.lat().toFixed(7));
                        this.longitude = parseFloat(pos.lng().toFixed(7));
                        console.log('[mapPicker] marker dragend ->', this.latitude, this.longitude);

                        // إرسال مباشر إلى Livewire (آمن لأنه يستخدم wire:id من الجذر)
                        const livewireRoot = this.$el.closest('[wire\\:id]');
                        if (livewireRoot) {
                            const compId = livewireRoot.getAttribute('wire:id');
                            try {
                                window.Livewire.find(compId).set('{{ $getStatePath() }}', {
                                    latitude: this.latitude,
                                    longitude: this.longitude
                                });
                                console.log('[mapPicker] Livewire updated via find(', compId, ')');
                            } catch (err) {
                                console.warn('Failed to set Livewire state via Livewire.find():', err);
                            }
                        }
                    });

                    // بعد الإنشاء نفّذ إعادة قياس للتأكد من عرض البلاطات
                    setTimeout(() => {
                        try {
                            google.maps.event.trigger(this.map, 'resize');
                            this.map.setCenter(center);
                            console.log('[mapPicker] triggered resize & recentre');
                        } catch (e) {
                            console.warn('resize failed', e);
                        }
                    }, 150);

                    // استمع لتغيير حجم النافذة لإعادة القياس
                    window.addEventListener('resize', () => {
                        if (this.map) {
                            google.maps.event.trigger(this.map, 'resize');
                            this.map.setCenter({
                                lat: this.latitude,
                                lng: this.longitude
                            });
                        }
                    });

                    this.initialized = true;
                }
            };
        }
    </script>
</x-dynamic-component>
