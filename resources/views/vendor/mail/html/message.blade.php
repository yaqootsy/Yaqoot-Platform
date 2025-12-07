<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <x-mail::header :url="config('app.url')">
            {{-- الصورة رابط عام --}}
            {{-- <img src="{{ url('img/d.png') }}" alt="{{ config('app.name') . ' Logo' }}" class="logo"> --}}
            {{-- الصورة مرفقة في الايميل نفسه --}}
            {{-- <img src="{{ $message->embed(public_path('img/d.png')) }}" alt="{{ config('app.name') . ' Logo' }}" height="60"> --}}
            <img src="https://icons-for-free.com/iff/png/256/ruby+icon-1320195548836502503.png" alt="{{ config('app.name') . ' Logo' }}" height="60">

        </x-mail::header>
    </x-slot:header>

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        <x-slot:subcopy>
            <x-mail::subcopy>
                {{ $subcopy }}
            </x-mail::subcopy>
        </x-slot:subcopy>
    @endisset

    {{-- Footer --}}
    <x-slot:footer>
        <x-mail::footer>
            © {{ date('Y') }} {{ config('app.name') }}. {{ 'جميع الحقوق محفوظة.' }}
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
