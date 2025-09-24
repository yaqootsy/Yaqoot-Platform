@extends('layouts.temp')

@section('title', 'الصفحة غير موجودة')

@section('content')
<div class="text-center">
    <h1 class="text-9xl font-extrabold text-blue-500 mb-4 animate-bounce">404</h1>
    <h2 class="text-3xl font-semibold mb-2">الصفحة غير موجودة</h2>
    <p class="text-gray-600 dark:text-gray-300 mb-6">عذرًا، الصفحة التي تبحث عنها غير موجودة.</p>
    <a href="{{ url('/') }}" 
       class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-700 transition duration-300">
       العودة إلى الرئيسية
    </a>
</div>
@endsection
