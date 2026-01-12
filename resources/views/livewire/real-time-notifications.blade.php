<div wire:poll.5s="poll" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none">
    @foreach($notifications as $notification)
        <div wire:key="{{ $notification->id }}" 
             x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-2 opacity-0 scale-95"
             x-transition:enter-end="translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100 scale-100"
             x-transition:leave-end="translate-x-full opacity-0 scale-95"
             class="pointer-events-auto bg-white dark:bg-[#002B5B] border border-slate-200 dark:border-white/10 shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-2xl p-4 w-80 backdrop-blur-md relative overflow-hidden group">
            
            <!-- Progress Bar (Optional, simpler to just have close button for now) -->
            
            <div class="flex items-start gap-4">
                <!-- Icon -->
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-xl">
                    {{ $notification->data['icon'] ?? '🔔' }}
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0 pt-0.5">
                    <p class="text-sm font-bold text-[#002B5B] dark:text-white mb-0.5">
                        {{ $notification->data['title'] ?? 'Notification' }}
                    </p>
                    <p class="text-xs text-slate-500 dark:text-white/60 leading-relaxed line-clamp-2">
                        {{ $notification->data['message'] ?? '' }}
                    </p>
                </div>

                <!-- Close / Mark Read -->
                <button wire:click="markAsRead('{{ $notification->id }}')" 
                        @click="show = false"
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
