<div>
    <!-- Modal Overlay -->
    <div x-data="{ show: @entangle('showModal') }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.close()"></div>

        <!-- Modal Panel -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white dark:bg-[#0f172a] shadow-2xl transition-all border border-slate-200 dark:border-white/10">
                
                <!-- Header -->
                <div class="bg-slate-50 dark:bg-white/5 px-6 py-4 border-b border-slate-100 dark:border-white/10 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-[#002B5B] dark:text-white flex items-center gap-2">
                        <span class="text-red-500">🚩</span> Report Content
                    </h3>
                    <button wire:click="close" class="text-slate-400 hover:text-slate-600 dark:text-white/40 dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-4">
                    <p class="text-sm text-slate-600 dark:text-white/70">
                        Help us keep the community safe. Why are you flagging this content?
                    </p>

                    <!-- Reason Selection -->
                    <div class="space-y-2">
                        @php
                            $reasons = [
                                'Inappropriate Content' => 'Contains offensive, hateful, or explicit material.',
                                'Spam or Misleading' => 'It is spam, promotional, or purposefully misleading.',
                                'Incorrect Definition' => 'The definition is factually wrong or nonsensical.',
                                'Harassment' => 'It is targeting or bullying a specific individual.',
                                'Other' => 'Something else not listed above.'
                            ];
                        @endphp

                        @foreach($reasons as $value => $description)
                            <label class="flex items-start gap-3 p-3 rounded-xl border cursor-pointer group transition-all
                                        {{ $reason === $value 
                                            ? 'bg-brand-primary/5 border-brand-primary dark:bg-brand-accent/10 dark:border-brand-accent' 
                                            : 'border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5' }}">
                                <input type="radio" wire:model="reason" value="{{ $value }}" class="mt-1 text-brand-primary focus:ring-brand-primary border-slate-300">
                                <div>
                                    <div class="font-bold text-sm text-[#002B5B] dark:text-white">{{ $value }}</div>
                                    <div class="text-xs text-slate-500 dark:text-white/50">{{ $description }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <!-- Details Input -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-white/60 mb-2 uppercase tracking-wider">Additional Details (Optional)</label>
                        <textarea wire:model="details" 
                                  rows="3" 
                                  class="w-full rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5 p-3 text-sm text-[#002B5B] dark:text-white placeholder:text-slate-400 focus:border-brand-primary focus:ring-brand-primary dark:focus:border-brand-accent dark:focus:ring-brand-accent outline-none transition-all"
                                  placeholder="Provide any extra context..."></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-slate-50 dark:bg-white/5 px-6 py-4 border-t border-slate-100 dark:border-white/10 flex justify-end gap-3">
                    <button wire:click="close" class="px-4 py-2 text-sm font-bold text-slate-600 dark:text-white/70 hover:text-slate-800 dark:hover:text-white transition-colors">
                        Cancel
                    </button>
                    <button wire:click="submit" 
                            @if(empty($reason)) disabled @endif
                            class="px-5 py-2 bg-red-500 text-white text-sm font-bold rounded-lg shadow-lg hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center gap-2">
                        <span>Submit Report</span>
                        <svg wire:loading wire:target="submit" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
