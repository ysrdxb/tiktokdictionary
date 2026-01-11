<div>
    <h1 class="text-3xl font-bold mb-6">System Settings</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Sidebar/Tabs -->
        <div class="bg-[#001f42] rounded-xl border border-white/10 overflow-hidden h-fit">
            <nav class="flex flex-col">
                <button wire:click="$set('group', 'general')" class="px-6 py-4 text-left font-bold text-sm hover:bg-white/5 {{ $group === 'general' ? 'bg-brand-primary text-white' : 'text-gray-400' }}">
                    General
                </button>
                <button wire:click="$set('group', 'moderation')" class="px-6 py-4 text-left font-bold text-sm hover:bg-white/5 {{ $group === 'moderation' ? 'bg-brand-primary text-white' : 'text-gray-400' }}">
                    Moderation (Coming Soon)
                </button>
                <button wire:click="$set('group', 'api')" class="px-6 py-4 text-left font-bold text-sm hover:bg-white/5 {{ $group === 'api' ? 'bg-brand-primary text-white' : 'text-gray-400' }}">
                    API Keys (Coming Soon)
                </button>
            </nav>
        </div>

        <!-- Form -->
        <div class="md:col-span-2">
            <div class="bg-[#001f42] p-8 rounded-xl border border-white/10">
                <form wire:submit.prevent="save">
                    
                    @if($group === 'general')
                        <h2 class="text-xl font-bold mb-6 pb-4 border-b border-white/10">General Configuration</h2>
                        
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Site Name</label>
                            <input wire:model="settings.site_name" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white">
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tagline</label>
                            <input wire:model="settings.tagline" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white">
                        </div>

                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3">
                                    <input wire:model="settings.maintenance_mode" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary">
                                    <span class="font-bold text-sm">Maintenance Mode</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Take the site offline for everyone except admins.</p>
                            </div>
                            
                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3">
                                    <input wire:model="settings.allow_submissions" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary">
                                    <span class="font-bold text-sm">Allow Submissions</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Enable or disable new word submissions.</p>
                            </div>
                        </div>

                    @else
                        <div class="text-center py-20">
                            <h3 class="text-xl font-bold text-gray-500">Coming Soon</h3>
                            <p class="text-gray-600">This settings module is under construction.</p>
                        </div>
                    @endif

                    <div class="flex justify-end pt-6 border-t border-white/10">
                        <button type="submit" class="px-6 py-2.5 bg-green-500 text-white font-bold rounded-lg hover:bg-green-400 transition-colors shadow-lg shadow-green-500/20">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
