@props([
    'canonical' => url()->current(),
    'description' => 'شروحات متقدمة في Laravel و PHP ومحتوى تقني عربي فريد.',
    'image' => '',
    'title' => config('app.name'),
])

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" dir="rtl">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
        <link rel="icon" type="image/png"  href="{{ asset('favicon/favicon.png') }}">
        {{-- <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon/favicon-48x48.png') }}">
        <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('favicon/favicon-64x64.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('favicon/favicon-128x128.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/favicon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('favicon/favicon-256x256.png') }}"> --}}
        <title>{{ $title }}</title>
        <meta name="keywords" content="معاذ الغرابلي, Laravel, PHP, مطور ويب, API, دروس برمجة, pushCode">
        <meta name="title" content="{{ $title }}" />
        <meta name="description" content="{{ $description }}" />
        <meta name="author" content="Muath Algharabli">
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:title" content="{{ $title }}" />
        <meta property="og:description" content="{{ $description }}" />
        <meta property="og:image" content="{{ $image }}" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:url" content="{{ url()->current() }}" />
        <meta name="twitter:title" content="{{ $title }}" />
        <meta name="twitter:description" content="{{ $description }}" />
        <meta name="twitter:image" content="{{ $image }}" />

        <script async src="https://www.googletagmanager.com/gtag/js?id=G-73Z0E87ZTV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-73Z0E87ZTV');
</script>

        <livewire:styles />

        @vite('resources/css/app.css')

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" />

        <link rel="canonical" href="{{ $canonical }}">
    </head>
    <body {{ $attributes->class('font-light text-gray-600') }}>
        <div class="flex flex-col min-h-screen">
            @empty($hideNavigation)
                <header class="container mt-4 xl:max-w-screen-lg">
                    <x-nav />
                </header>
            @endempty

            <main @class([
                'flex-grow',
                'mt-8' => empty($hideNavigation),
            ])>
                {{ $slot }}
            </main>

            @empty($hideFooter)
                <x-footer class="mt-8 md:mt-16" />
            @endempty
        </div>

        <x-status />

        @livewireScriptConfig

        @vite('resources/js/app.js')
    </body>
</html>
