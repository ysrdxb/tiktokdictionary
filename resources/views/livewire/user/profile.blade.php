<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl shadow-indigo-100 overflow-hidden mb-8 border border-slate-100 relative">
        <div class="h-32 bg-gradient-to-r from-[#00336E] to-[#0F62FE]"></div>
        <div class="px-8 pb-8">
            <div class="relative flex items-end -mt-12 mb-6">
                <div class="h-24 w-24 rounded-2xl bg-white p-1 shadow-lg">
                    <div class="h-full w-full bg-slate-100 rounded-xl flex items-center justify-center text-3xl font-black text-slate-300">
                        {{ substr($user->username, 0, 1) }}
                    </div>
                </div>
                <div class="ml-6 mb-1">
                    <h1 class="text-3xl font-black text-[#00336E]">{{ $user->username }}</h1>
                    <div class="text-sm font-bold text-slate-400">Joined {{ $user->created_at->format('M Y') }}</div>
                </div>
                <div class="ml-auto mb-2 flex gap-3">
                     <!-- Edit Profile Button (If own profile) -->
                    @if(auth()->check() && auth()->id() === $user->id)
                        <button class="px-4 py-2 bg-slate-100 text-slate-600 font-bold rounded-lg text-sm hover:bg-slate-200 transition-colors">
                            Edit Profile
                        </button>
                    @endif
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Reputation</div>
                    <div class="text-2xl font-black text-[#0F62FE]">{{ number_format($user->reputation_score ?? 0) }}</div>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Words</div>
                    <div class="text-2xl font-black text-[#00336E]">{{ $words->count() }}</div>
                </div>
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Definitions</div>
                    <div class="text-2xl font-black text-[#00336E]">{{ $definitions->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Tabs -->
    <div x-data="{ activeTab: 'words' }">
        <div class="flex gap-2 mb-6 border-b border-slate-200 pb-1">
            <button @click="activeTab = 'words'" 
                :class="activeTab === 'words' ? 'text-[#00336E] border-[#0F62FE] bg-white' : 'text-slate-400 border-transparent hover:text-slate-600'"
                class="px-6 py-2 text-sm font-bold rounded-t-lg border-b-2 transition-all">
                Words Created
            </button>
            <button @click="activeTab = 'definitions'" 
                :class="activeTab === 'definitions' ? 'text-[#00336E] border-[#0F62FE] bg-white' : 'text-slate-400 border-transparent hover:text-slate-600'"
                class="px-6 py-2 text-sm font-bold rounded-t-lg border-b-2 transition-all">
                Definitions
            </button>
        </div>

        <!-- Words Tab -->
        <div x-show="activeTab === 'words'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($words as $word)
                <a href="{{ route('word.show', $word->slug) }}" class="block p-5 bg-white rounded-xl shadow-sm border border-slate-200 hover:border-pink-500 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-black text-lg text-[#00336E] group-hover:text-pink-600 transition-colors">{{ $word->term }}</h3>
                        <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">{{ $word->category }}</span>
                    </div>
                    <div class="text-sm text-slate-500 line-clamp-2">
                         <!-- Fallback to primary definition since we don't have it eager loaded in this specific query easily without messing up -->
                         {{ $word->primaryDefinition->definition ?? 'No definition yet.' }}
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 italic">No words submitted yet.</div>
            @endforelse
        </div>

        <!-- Definitions Tab -->
        <div x-show="activeTab === 'definitions'" class="space-y-4">
            @forelse($definitions as $def)
                <div class="p-5 bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold text-slate-400">Defined for</span>
                        <a href="{{ route('word.show', $def->word->slug) }}" class="font-bold text-[#0F62FE] hover:underline">{{ $def->word->term }}</a>
                    </div>
                    <div class="text-lg font-medium text-[#00336E] mb-2">
                        {{ $def->definition }}
                    </div>
                    @if($def->example)
                        <div class="text-sm text-slate-500 italic mb-3">"{{ $def->example }}"</div>
                    @endif
                    <div class="flex items-center gap-4 text-xs font-bold text-slate-400">
                        <span class="flex items-center gap-1"><span class="text-green-600">{{ $def->agrees }}</span> Facts</span>
                        <span class="flex items-center gap-1"><span class="text-red-400">{{ $def->disagrees }}</span> Cap</span>
                        <span class="ml-auto">{{ $def->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 italic">No definitions submitted yet.</div>
            @endforelse
        </div>
    </div>
</div>
