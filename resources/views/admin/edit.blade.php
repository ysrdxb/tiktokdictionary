<x-layouts.app>
    <div class="min-h-screen bg-slate-100 py-10">
        <div class="max-w-[1000px] mx-auto px-6">
            
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm">← Back to Dashboard</a>
            </div>

            <div class="grid grid-cols-3 gap-8">
                <!-- Main Edit Form -->
                <div class="col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                        <h2 class="text-2xl font-bold text-[#002B5B] mb-6">Edit Word: {{ $word->term }}</h2>
                        
                        <form action="{{ route('admin.words.update', $word->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Basic Info -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Term</label>
                                    <input type="text" name="term" value="{{ $word->term }}" class="w-full border-slate-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Category</label>
                                    <select name="category" class="w-full border-slate-300 rounded-lg">
                                        @foreach(['Slang', 'TikTok', 'Memes', 'Gaming', 'Internet', 'Gen-Z'] as $cat)
                                            <option value="{{ $cat }}" {{ $word->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <hr class="border-slate-100">

                            <!-- Viral Engine Controls -->
                            <div>
                                <h3 class="font-black text-[#002B5B] uppercase tracking-wider text-sm mb-4">Viral Engine Controls</h3>
                                
                                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">Admin Boost (0 - 10,000)</label>
                                        <input type="number" name="admin_boost" value="{{ $word->admin_boost }}" class="w-full border-slate-300 rounded-lg font-mono">
                                        <p class="text-xs text-slate-500 mt-1">Directly adds to the numerator of the velocity formula.</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1">RFCI Score (Optional)</label>
                                        <input type="text" name="rfci_score" value="{{ $word->rfci_score }}" class="w-full border-slate-300 rounded-lg">
                                    </div>

                                    <div class="flex items-center gap-6 pt-2">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="is_polar_trend" value="1" {{ $word->is_polar_trend ? 'checked' : '' }} class="rounded text-cyan-500 focus:ring-cyan-500">
                                            <span class="font-bold text-slate-700">Polar Trend (Neon Pulse)</span>
                                        </label>
                                        
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="is_verified" value="1" {{ $word->is_verified ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-600">
                                            <span class="font-bold text-slate-700">Verified</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-4 bg-[#002B5B] text-white font-bold rounded-xl hover:bg-slate-800 transition-colors">
                                Save Changes & Recalculate Velocity
                            </button>
                        </form>
                    </div>

                    <!-- Delete Zone -->
                    <div class="bg-red-50 rounded-xl border border-red-100 p-6">
                        <h3 class="text-red-800 font-bold mb-2">Danger Zone</h3>
                        <form action="{{ route('admin.words.destroy', $word->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-sm font-bold hover:underline">Delete Word Permanently</button>
                        </form>
                    </div>
                </div>

                <!-- Lore Sidebar -->
                <div class="col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-6">
                        <h3 class="font-bold text-[#002B5B] mb-4">Lore Timeline</h3>
                        
                        <!-- Add Lore Form -->
                        <form action="{{ route('admin.words.lore.store', $word->id) }}" method="POST" class="space-y-3 mb-6">
                            @csrf
                            <input type="text" name="title" placeholder="Event Title" class="w-full text-sm border-slate-200 rounded-lg" required>
                            <textarea name="description" placeholder="Description..." rows="2" class="w-full text-sm border-slate-200 rounded-lg" required></textarea>
                            <input type="date" name="date_event" class="w-full text-sm border-slate-200 rounded-lg" required>
                            <input type="url" name="source_url" placeholder="Source URL" class="w-full text-sm border-slate-200 rounded-lg">
                            <button type="submit" class="w-full py-2 bg-slate-100 text-[#002B5B] text-xs font-bold rounded-lg hover:bg-slate-200">
                                + Add Lore Entry
                            </button>
                        </form>

                        <!-- Existing Lore -->
                        <div class="space-y-4">
                            @foreach($word->lore as $lore)
                                <div class="border-l-2 border-slate-200 pl-3 py-1">
                                    <div class="text-[10px] text-slate-400 font-bold">{{ $lore->date_event->format('M Y') }}</div>
                                    <div class="text-sm font-bold text-[#002B5B]">{{ $lore->title }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
