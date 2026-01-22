<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'موقعي'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?php echo e(url('/')); ?>" class="text-xl font-bold text-blue-600 dark:text-blue-400"><?php echo e(config('app.name')); ?></a>
            <nav class="space-x-4">
                <a href="<?php echo e(url('/')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">الرئيسية</a>
            </nav>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-white dark:bg-gray-800 shadow-inner py-6 mt-8">
        <p class="text-center text-gray-600 dark:text-gray-400">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?></p>
    </footer>
</body>

</html>
<?php /**PATH /var/www/html/resources/views/layouts/temp.blade.php ENDPATH**/ ?>