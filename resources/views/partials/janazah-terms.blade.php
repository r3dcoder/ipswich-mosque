@if($terms || ($termsPoints ?? collect())->isNotEmpty())
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="janazah-terms-box bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mt-12">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-emerald-50">
                <svg class="w-6 h-6" style="color: var(--brand-green);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">
                {{ $terms->title ?? 'Body Wash Facility Terms & Conditions' }}
            </h3>
        </div>

        <div class="prose prose-slate max-w-none text-gray-600 leading-relaxed space-y-4">
            @if($terms && $terms->content)
                <div class="space-y-4">
                    {!! nl2br(e($terms->content)) !!}
                </div>
            @endif

            @if(($termsPoints ?? collect())->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                    @foreach($termsPoints as $point)
                        <div>
                            @if($point->title)
                                <h4 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $point->title }}
                                </h4>
                            @endif
                            @if($point->content)
                                <div class="space-y-2 text-sm">
                                    {!! nl2br(e($point->content)) !!}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endif
