<div class="container mt-12 md:mt-16 lg:max-w-screen-md">
    <div class="grid grid-cols-3 gap-4 leading-tight md:grid-cols-3">
        <div class="flex-1 p-3 text-center rounded-lg bg-gray-50">
            <x-heroicon-o-calendar class="mx-auto mb-1 opacity-75 size-6" />
            {{ $post['modified_at'] ? 'تم تعديله' : 'تم نشره' }}<br />
            {{ ($post['modified_at'] ?? $post['published_at'])->isoFormat('ll') }}
        </div>

        <div class="flex-1 p-3 text-center rounded-lg bg-gray-50">
            <x-heroicon-o-user class="mx-auto mb-1 opacity-75 size-6" />
            كتب بواصة<br />
            معاذ الغرابلي
        </div>

        <a href="#comments" class="group">
            <div @class([
                'flex-1 p-3 text-center transition-colors rounded-lg bg-gray-50 hover:bg-blue-50 group-hover:text-blue-900',
                'text-blue-600' => $post['comments_count'] > 0,
            ])>
                <x-heroicon-o-chat-bubble-oval-left-ellipsis class="mx-auto mb-1 opacity-75 size-6" />
                {{ $post['comments_count'] }}<br />
                {{ trans_choice('تعليق|تعليقات', $post['comments_count']) }}
            </div>
        </a>

        {{-- <div class="flex-1 p-3 text-center rounded-lg bg-gray-50">
            <x-heroicon-o-clock class="mx-auto mb-1 opacity-75 size-6" />
            {{ $readTime ?? 0 }} minutes<br />
            قراءة
        </div> --}}
    </div>

    {{-- <x-table-of-contents
        :headings="extract_headings_from_markdown($post['content'])"
        class="mt-4 ml-0"
    /> --}}

    <x-prose class="mt-12 md:mt-16">
        {!! Str::markdown($post['content']) !!}
    </x-prose>
</div>