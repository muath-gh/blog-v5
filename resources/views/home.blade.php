<x-app>
    <div class="container mt-8 text-center">
        @if ($visitors > 10)
            <div class="font-bold tracking-tight text-black text-4xl/none md:text-5xl lg:text-7xl text-balance">
                <span class="text-primary-color">{{ Number::format($visitors) }}</span> monthly visitors read my blog
            </div>
        @endif

        <div
            class="mt-5 leading-tight text-black/75 text-lg/tight sm:text-xl/tight md:text-2xl/tight md:mt-8 lg:text-3xl text-balance">
            سواء كنتَ في بداية الطريق أو بلغتَ أعلى درجات الخبرة، ستجد هنا ما يُلهمك ويُضيف إلى معرفتك قيمة حقيقية.
        </div>

        <div class="flex items-center justify-center gap-2 text-center mt-7 md:mt-11">
            <x-btn href="#about">
                من أكون؟
            </x-btn>

            <x-btn primary href="#latest">
                استكشف المحتوى الآن
            </x-btn>
        </div>
    </div>

    {{-- <x-section title="They support the blog" class="mt-24 md:mt-32 lg:max-w-screen-md">
        <div class="flex flex-wrap justify-center mt-8 gap-y-4 gap-x-12">
            <a href="https://beyondco.de/?utm_source=benjamincrozat&utm_medium=logo&utm_campaign=benjamincrozat"
                target="_blank">
                <x-icon-beyond-code class="h-7 md:h-8" />
                <span class="sr-only">Beyond Code</span>
            </a>

            <a href="https://nobinge.ai" target="_blank">
                <x-icon-nobinge class="h-6 md:h-7" />
                <span class="sr-only">Nobinge</span>
            </a>
        </div>

        <div class="text-center sm:text-xl mt-7">
            If you like my blog, please check out these development/education-centric products that will help you as a
            developer without a doubt.
        </div>
    </x-section> --}}

    <x-section title="أحدث المقالات" id="latest" class="mt-24 md:mt-32">
        @if ($latest->isNotEmpty())
            <ul class="grid gap-10 mt-8 gap-y-16 xl:gap-x-16 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($latest as $post)
                    <li>
                        <x-post :$post />
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-16 text-center">
            <x-btn primary wire:navigate href="{{ route('posts.index') }}">
                تصفح جميع المقالات
            </x-btn>
        </div>
    </x-section>

    <x-section title="عن معاذ الغرابلي" id="about" class="mt-24 lg:max-w-screen-md md:mt-32">
        <x-prose class="mt-8">
            <img src="{{asset('imgs/avatar.png')}}" alt="Benjamin Crozat"
                class="float-right mt-4 ml-4 !rounded-full size-28 md:size-32" />

                {!! Str::markdown(
                    <<<MARKDOWN
                    مرحبًا! اسمي **معاذ الغرابلي**، وأنا مطوّر ويب شغوف بالتعلّم ومشاركة المعرفة، وصاحب قناة **Push Code** التعليمية التي تهدف إلى تقديم محتوى برمجي عربي احترافي ومبسّط في الوقت نفسه.
                    
                    بدأت رحلتي في عالم البرمجة من منطلق حب الاستكشاف والتجربة. أؤمن أن التعلّم الذاتي هو أحد أقوى الأدوات التي يمكن أن تغيّر حياة الإنسان، تمامًا كما غيّرت حياتي. لهذا السبب، أصبحت مشاركة ما أتعلمه مع الآخرين أمرًا أساسيًا في مسيرتي، بل وأعتبره جزءًا لا يتجزأ من أي نجاح حقيقي.
                    
                    وانطلاقًا من هذه الرؤية، قررت أن أبدأ بعدة خطوات ملموسة:
                    
                    1. أنشأت قناة Push Code على يوتيوب، حيث أقدّم فيها شروحات عملية باللغة العربية حول تطوير البرمجيات، مع التركيز على المفاهيم المتقدمة والمواضيع التي يندر تناولها عربيًا، بغضّ النظر عن اللغة أو الأداة المستخدمة.
                    2. أعمل على إنشاء محتوى تعليمي احترافي، سواء من خلال فيديوهات قصيرة أو شروحات مفصّلة، تدمج بين الجانب التطبيقي والنظري.
                    3. بدأت ببناء مجتمعي الخاص من المتابعين والمبرمجين الطموحين، وأسعى دائمًا لخلق مساحة تفاعلية نشارك فيها المعرفة ونتطوّر سويًا.
                    4. أؤمن أن التعليم لا يجب أن يكون حكرًا، لذلك أحرص على أن يكون المحتوى الذي أقدّمه مجانيًا ومتاحًا للجميع.
                    
                    هدفي القادم هو بناء منتجات رقمية وسلسلة دورات تعليمية عربية تغطي مواضيع متقدمة في البرمجة، مع التركيز على الجودة والقيمة الحقيقية التي يحصل عليها المتابع.
                    
                    **أنا فقط في البداية، والقادم أفضل بإذن الله.**
                    
                    MARKDOWN
                    )
                    !!}
        </x-prose>
    </x-section>
</x-app>
