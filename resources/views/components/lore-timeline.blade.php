@props(['entries'])

@if($entries->count() > 0)
<div class="bg-white dark:bg-white/5 rounded-2xl border border-slate-200 dark:border-white/10 p-6">
    <h3 class="text-xl font-bold text-[#00336E] dark:text-white mb-6 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Origin Timeline
    </h3>

    <div class="relative">
        <!-- Timeline line -->
        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-200 dark:bg-white/10"></div>

        <div class="space-y-6">
            @foreach($entries->sortByDesc('date_event') as $entry)
            <div class="relative pl-10">
                <!-- Dot -->
                <div class="absolute left-2.5 top-1.5 w-3 h-3 rounded-full bg-[#00336E] dark:bg-white border-2 border-white dark:border-[#00336E]"></div>

                <!-- Content -->
                <div>
                    <div class="text-xs text-slate-500 dark:text-white/50 font-bold uppercase tracking-wider mb-1">
                        {{ $entry->date_event ? \Illuminate\Support\Carbon::parse($entry->date_event)->format('M d, Y') : 'Date N/A' }}
                    </div>
                    <h4 class="font-bold text-[#00336E] dark:text-white">{{ $entry->title }}</h4>
                    <p class="text-slate-600 dark:text-white/70 text-sm mt-1">{{ $entry->description }}</p>
                    @if($entry->source_url)
                        <a href="{{ $entry->source_url }}" target="_blank"
                           class="inline-flex items-center gap-1 text-xs text-blue-600 dark:text-blue-400 hover:underline mt-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            View Source
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
    <div class="bg-slate-50 rounded-2xl border border-slate-200 border-dashed p-8 text-center">
        <div class="w-12 h-12 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-3">
             <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <p class="text-[#00336E]/60 font-medium">No recorded timeline events for this word yet.</p>
        <p class="text-xs text-slate-400 mt-1">Is this word old news? Submit an origin story.</p>
    </div>
@endif
