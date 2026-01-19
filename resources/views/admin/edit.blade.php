<x-layouts.admin>
    <div>
        <!-- Page Header -->
        <div class="flex items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.words') }}" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Edit: {{ $word->term }}</h1>
                    <p class="text-gray-400 text-sm">Modify word settings, boost scores, and manage lore</p>
                </div>
            </div>
            <a href="{{ route('word.show', $word->slug) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-bold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                View Public Page
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Edit Form -->
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('admin.words.update', $word->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Basic Info Card -->
                    <div class="bg-[#001f42] rounded-xl border border-white/10 p-6 mb-6">
                        <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Basic Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Term</label>
                                <input type="text" name="term" value="{{ $word->term }}"
                                       class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:outline-none focus:border-brand-accent">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Category</label>
                                <select name="category" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:outline-none focus:border-brand-accent">
                                    @foreach(['Slang', 'TikTok', 'Memes', 'Gaming', 'Internet', 'Gen-Z'] as $cat)
                                        <option value="{{ $cat }}" {{ $word->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Viral Engine Controls -->
                    <div class="bg-[#001f42] rounded-xl border border-white/10 p-6 mb-6">
                        <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Viral Engine Controls
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Admin Boost (0 - 10,000)</label>
                                <input type="number" name="admin_boost" value="{{ $word->admin_boost }}" min="0" max="10000"
                                       class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white font-mono focus:outline-none focus:border-brand-accent">
                                <p class="text-xs text-gray-500 mt-1">Directly adds to the numerator of the velocity formula.</p>
                            </div>


                            <div class="flex flex-wrap items-center gap-6 pt-4 border-t border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="is_polar_trend" value="1" {{ $word->is_polar_trend ? 'checked' : '' }}
                                           class="w-5 h-5 rounded bg-black/20 border-white/20 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-0">
                                    <span class="font-bold text-white group-hover:text-cyan-400 transition-colors">Polar Trend</span>
                                    <span class="text-xs text-cyan-400 bg-cyan-500/10 px-2 py-0.5 rounded">Neon Pulse</span>
                                </label>

                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="is_verified" value="1" {{ $word->is_verified ? 'checked' : '' }}
                                           class="w-5 h-5 rounded bg-black/20 border-white/20 text-blue-500 focus:ring-blue-500 focus:ring-offset-0">
                                    <span class="font-bold text-white group-hover:text-brand-accent transition-colors">Verified</span>
                                    <span class="text-xs text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded">Blue Check</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Display -->
                    <div class="bg-[#001f42] rounded-xl border border-white/10 p-6 mb-6">
                        <h2 class="text-lg font-bold text-white mb-4">Current Stats</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-black/20 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-white">{{ number_format($word->views) }}</p>
                                <p class="text-xs text-gray-500 uppercase">Views</p>
                            </div>
                            <div class="bg-black/20 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-green-400">{{ number_format($word->velocity_score, 1) }}</p>
                                <p class="text-xs text-gray-500 uppercase">Velocity</p>
                            </div>
                            <div class="bg-black/20 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-purple-400">{{ $word->definitions_count ?? $word->definitions->count() }}</p>
                                <p class="text-xs text-gray-500 uppercase">Definitions</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-brand-primary to-pink-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-brand-primary/30 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Save Changes & Recalculate Velocity
                    </button>
                </form>

                <!-- Danger Zone -->
                <div class="bg-red-500/10 rounded-xl border border-red-500/20 p-6">
                    <h3 class="text-red-400 font-bold mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Danger Zone
                    </h3>
                    <p class="text-gray-400 text-sm mb-4">This action cannot be undone. The word and all its definitions will be permanently deleted.</p>
                    <form action="{{ route('admin.words.destroy', $word->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this word? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-400 text-sm font-bold rounded-lg hover:bg-red-500/30 transition-colors">
                            Delete Word Permanently
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lore Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-[#001f42] rounded-xl border border-white/10 p-6 sticky top-6">
                    <h3 class="font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Lore Timeline
                    </h3>

                    <!-- Add Lore Form -->
                    <form action="{{ route('admin.words.lore.store', $word->id) }}" method="POST" class="space-y-3 mb-6 pb-6 border-b border-white/10">
                        @csrf
                        <input type="text" name="title" placeholder="Event Title" required
                               class="w-full text-sm bg-black/20 border border-white/10 rounded-lg p-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent">
                        <textarea name="description" placeholder="Description..." rows="2" required
                                  class="w-full text-sm bg-black/20 border border-white/10 rounded-lg p-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent"></textarea>
                        <input type="date" name="date_event" required
                               class="w-full text-sm bg-black/20 border border-white/10 rounded-lg p-2.5 text-white focus:outline-none focus:border-brand-accent">
                        <input type="url" name="source_url" placeholder="Source URL (optional)"
                               class="w-full text-sm bg-black/20 border border-white/10 rounded-lg p-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-brand-accent">
                        <button type="submit" class="w-full py-2.5 bg-purple-500/20 text-purple-400 text-xs font-bold rounded-lg hover:bg-purple-500/30 transition-colors flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Lore Entry
                        </button>
                    </form>

                    <!-- Existing Lore -->
                    <div class="space-y-4">
                        @forelse($word->lore as $lore)
                            <div class="border-l-2 border-purple-500/50 pl-3 py-1">
                                <div class="text-[10px] text-gray-500 font-bold uppercase">{{ $lore->date_event->format('M Y') }}</div>
                                <div class="text-sm font-bold text-white">{{ $lore->title }}</div>
                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($lore->description, 80) }}</p>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <svg class="w-10 h-10 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-gray-500 text-sm">No lore entries yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
