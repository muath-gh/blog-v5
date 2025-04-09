<x-app :canonical="$post['canonical']" :description="$post['description']" :image="$post['image']" :title="$post['title']">
    {{-- <div class="flex items-center gap-8 px-4 mt-4 overflow-x-scroll md:px-8 snap-mandatory snap-x md:mt-8">
        @foreach (collect(config('merchants.books'))->shuffle() as $book)
            <x-book :$book class="flex-1 snap-start scroll-ml-4 md:scroll-ml-8 min-w-[150px]" />
        @endforeach
    </div> --}}

    <x-breadcrumbs class="container mt-12 md:mt-16 xl:max-w-screen-lg">
        <x-breadcrumbs.item href="{{ route('posts.index') }}">
            المقالات
        </x-breadcrumbs.item>

        <x-breadcrumbs.item class="line-clamp-1">
            {{ $post['title'] }}
        </x-breadcrumbs.item>
    </x-breadcrumbs>

    <article class="mt-12 md:mt-16">
        <div class="container break-all lg:max-w-screen-md">
            @if ($post['image'])
                <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}"
                    class="object-cover w-full shadow-xl ring-1 ring-black/5 rounded-xl aspect-video" />
            @endif
        </div>

        @if (!empty($post['categories']))
            <div class="flex justify-center gap-2 mt-12 md:mt-16">
                @foreach ($post['categories'] as $category)
                    <div class="px-2 py-1 text-xs font-medium uppercase border rounded">
                        {{ $category->name }}
                    </div>
                @endforeach
            </div>
        @endif

        <h1
            class="container mt-4 font-medium tracking-tight text-center text-black md:mt-8 text-balance text-3xl/none sm:text-4xl/none md:text-5xl/none lg:text-6xl/none">
            {{ $post['title'] }}
        </h1>

        <x-article-info :post="$post" />
    </article>

    <x-section id="comments" class="mt-12 md:mt-16 lg:max-w-screen-md">
        @auth
            <livewire:write-comment :post-slug="$post['slug']" />
        @else
            <div class="p-4 text-center text-gray-500 border rounded">
                <p>يرجى تسجيل الدخول لكتابة تعليق.</p>
                {{-- <a href="{{ route('login') }}" class="text-blue-600 hover:underline">تسجيل الدخول</a> --}}
            </div>
        @endauth

        <livewire:comments :post-slug="$post['slug']" />
    </x-section>

</x-notify/>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "author": {
                "@type": "Person",
                "name": "Benjamin Crozat",
                "url": "{{ route('home') }}#about"
            },
            "headline": "{{ $post['title'] }}",
            "description": "{{ $post['description'] }}",
            "image": "{{ $post['image'] }}",
            "datePublished": "{{ $post['published_at']->toIso8601String() }}",
            "dateModified": "{{ $post['modified_at']?->toIso8601String() ?? $post['published_at']->toIso8601String() }}"
        }
    </script>
</x-app>
