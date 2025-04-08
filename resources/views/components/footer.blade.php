<div {{ $attributes->class('bg-gray-100') }}>
    <footer class="container py-8">
        <nav class="flex flex-wrap items-center justify-center gap-x-8 gap-y-2">
            <a wire:navigate href="{{ route('home') }}" class="font-medium">الرئيسية</a>
            <a wire:navigate href="{{ route('posts.index') }}" class="font-medium">الأحدث</a>
            <a wire:navigate href="{{ route('links.index') }}" class="font-medium">روابط</a>
            <a href="{{ route('home') }}#about" class="font-medium">من أكون </a>
            <a href="mailto:hello@benjamincrozat.com" class="font-medium">تواصل معي</a>
        </nav>

        <p class="mt-6 text-center text-gray-400">جميع الحقوق محفوظة. © {{ date('Y')}}.</p>
    </footer>
</div>
