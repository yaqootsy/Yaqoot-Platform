<!DOCTYPE html>
<html dir="rtl" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('theme');
                if (!theme) {
                    // اختيار تلقائي بناءً على تفضيل النظام (اختياري)
                    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        theme = 'dark';
                    } else {
                        theme = 'light';
                    }
                }
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {
                /* silent */
            }
        })();
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(config('services.google.maps_key') ?? env('GOOGLE_MAPS_KEY')); ?>&libraries=places"></script>

    <!-- Scripts -->
    <?php echo app('Tighten\Ziggy\BladeRouteGenerator')->generate(); ?>
    <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.tsx', "resources/js/Pages/{$page['component']}.tsx"]); ?>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
</head>

<body class="font-sans antialiased">
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/app.blade.php ENDPATH**/ ?>