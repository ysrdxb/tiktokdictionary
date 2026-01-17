@props(['word'])

<div {{ $attributes->merge(['class' => 'premium-card p-6 flex flex-col w-full h-full min-h-[180px] bg-white rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 border border-[#00336E]/5 hover:-translate-y-1']) }}>
    <div class="flex justify-between items-start mb-2">
        <a href="{{ route('word.show', $word->slug) }}" class="block min-w-0 flex-1 group">
            <h3 class="text-xl font-bold text-[#00336E] group-hover:text-blue-600 transition-colors leading-tight tracking-tight truncate">
                {{ $word->term }}
            </h3>
        </a>
    </div>
    
    <div class="mb-3">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-bold bg-[#00336E]/[0.05] text-[#00336E] uppercase tracking-widest">
            {{ $word->category ?? 'Slang' }}
        </span>
    </div>
    
    <p class="text-[#00336E]/80 text-[14px] font-medium leading-[1.4] line-clamp-2 overflow-hidden mb-auto">
        {{ optional($word->primaryDefinition)->definition ?? 'No definition available yet. Be the first to add one!' }}
    </p>
    
    <div class="flex items-center justify-between mt-4">
        <div class="flex items-center gap-2 text-[#00336E]">
            <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
            </svg>
            <span class="text-[11px] font-black tracking-tight">{{ number_format($word->total_agrees ?? 0) }} Agreed</span>
        </div>
        
        <a href="{{ route('word.show', $word->slug) }}" class="text-[10px] font-black text-[#00336E]/40 hover:text-[#00336E] uppercase tracking-widest transition-colors">
            View Details →
        </a>
    </div>
</div>
