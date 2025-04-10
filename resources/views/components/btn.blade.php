@if ($attributes->has('href'))
<a
@else
<button
@endif
    {{
        $attributes
            ->class([
                'inline-block font-medium rounded-xl transition-colors',
                'bg-gray-200 hover:bg-gray-100' => ! $attributes->has('primary'),
                'bg-primary-color hover:bg-blue-500 text-white' => $attributes->has('primary'),
                'px-6 py-3' => ! $attributes->has('size'),
                'px-6 py-3 text-lg' => 'md' === $attributes->get('size'),
                'px-[.65rem] py-[.35rem] text-sm rounded-md' => 'sm' === $attributes->get('size'),
                'px-[.65rem] py-[.35rem] text-xs rounded' => 'xs' === $attributes->get('size'),
            ])
            ->merge([
                'href' => route('posts.index'),
            ])
    }}
>
    {{ $slot }}
@if ($attributes->has('href'))
</a>
@else
</button>
@endif
