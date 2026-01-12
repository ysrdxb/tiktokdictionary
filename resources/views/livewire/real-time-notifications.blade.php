<div wire:poll.2500ms="poll" class="fixed bottom-6 right-6 z-[100] flex flex-col-reverse gap-3 pointer-events-none">
    @foreach($notifications as $notification)
        <div wire:key="{{ $notification['id'] }}" 
             x-data="{ 
                show: true,
                init() {
                    // Check if we've already seen this global notification locally
                    const seenKey = 'seen_notification_{{ $notification['id'] }}';
                    if (sessionStorage.getItem(seenKey)) {
                        this.show = false;
                    } else {
                        // If new, show it, then mark as seen in session after partial duration
                        setTimeout(() => {
                            this.show = false;
                            sessionStorage.setItem(seenKey, 'true');
                            // Only call backend to mark read if it's personal
                            if (!'{{ $notification['id'] }}'.startsWith('word_')) {
                                setTimeout(() => $wire.markAsRead('{{ $notification['id'] }}'), 300);
                            }
                        }, 5000); 
                    }
                }
             }"
             x-show="show"
             @mouseenter="show = true" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0 scale-95"
             x-transition:enter-end="translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0 opacity-100 scale-100"
             x-transition:leave-end="translate-x-full opacity-0 scale-95"
             class="pointer-events-auto bg-white dark:bg-[#002B5B] border border-slate-200 dark:border-white/10 shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-2xl p-4 w-80 backdrop-blur-md relative overflow-hidden group cursor-pointer hover:shadow-xl transition-all">
            
            <div class="flex items-start gap-4">
                <!-- Icon -->
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-xl">
                    {{ $notification['data']['icon'] ?? '🔔' }}
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0 pt-0.5">
                    <p class="text-xs font-bold text-slate-400 dark:text-white/60 uppercase tracking-wider mb-1">
                        {{ $notification['data']['title'] ?? 'Notification' }}
                    </p>
                    
                    @if(isset($notification['data']['word']))
                        <div class="text-lg font-black text-[#002B5B] dark:text-white leading-none mb-1">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-secondary">
                                {{ $notification['data']['word'] }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-white/60">
                            has passed the vibe check.
                        </p>
                    @else
                        <p class="text-sm font-bold text-[#002B5B] dark:text-white leading-snug">
                            {{ $notification['data']['message'] ?? '' }}
                        </p>
                    @endif
                </div>

                <!-- Close Button -->
                <button @click="show = false; sessionStorage.setItem('seen_notification_{{ $notification['id'] }}', 'true');"
                        class="flex-shrink-0 text-slate-400 hover:text-brand-primary dark:text-white/30 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Time -->
            <div class="absolute bottom-2 right-4">
                <span class="text-[10px] text-slate-300 dark:text-white/20 font-bold tracking-widest uppercase">Just Now</span>
            </div>
            
            <!-- Accent Bar -->
            <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-primary"></div>
        </div>
    @endforeach
</div>
