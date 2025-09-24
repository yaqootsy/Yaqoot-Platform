<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'موقعي')</title>
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900">
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ config('app.name') }}</a>
            <nav class="space-x-4">
                <a href="{{ url('/') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">الرئيسية</a>
            </nav>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-4">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800 shadow-inner py-6 mt-8">
        <p class="text-center text-gray-600 dark:text-gray-400">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </footer>
</body>

</html>
