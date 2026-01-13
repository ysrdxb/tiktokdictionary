<div>
    <!-- Page Header -->
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white">System Settings</h1>
            <p class="text-gray-400 text-sm">Configure site behavior, APIs, and global options</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Sidebar/Tabs -->
        <div class="bg-[#001f42] rounded-xl border border-white/10 overflow-hidden h-fit">
            <nav class="flex flex-col">
                <button wire:click="$set('group', 'general')" class="px-6 py-4 text-left font-bold text-sm hover:bg-white/5 transition-colors flex items-center gap-3 {{ $group === 'general' ? 'bg-brand-primary text-white' : 'text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    General
                </button>
                <button wire:click="$set('group', 'api')" class="px-6 py-4 text-left font-bold text-sm hover:bg-white/5 transition-colors flex items-center gap-3 {{ $group === 'api' ? 'bg-brand-primary text-white' : 'text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    API & Integrations
                </button>
                <button wire:click="$set('group', 'moderation')" class="px-6 py-4 text-left font-bold text-sm hover:bg-white/5 transition-colors flex items-center gap-3 {{ $group === 'moderation' ? 'bg-brand-primary text-white' : 'text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Moderation
                </button>
            </nav>
        </div>

        <!-- Form -->
        <div class="md:col-span-2">
            <div class="bg-[#001f42] p-8 rounded-xl border border-white/10">
                <form wire:submit.prevent="save">

                    {{-- GENERAL SETTINGS --}}
                    @if($group === 'general')
                        <h2 class="text-xl font-bold mb-6 pb-4 border-b border-white/10 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            General Configuration
                        </h2>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Site Name</label>
                            <input wire:model="settings.site_name" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tagline</label>
                            <input wire:model="settings.tagline" type="text" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.maintenance_mode" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary focus:ring-brand-primary">
                                    <span class="font-bold text-sm">Maintenance Mode</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Take the site offline for everyone except admins.</p>
                            </div>

                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.allow_submissions" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary focus:ring-brand-primary">
                                    <span class="font-bold text-sm">Allow Submissions</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Enable or disable new word submissions.</p>
                            </div>

                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.allow_voting" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary focus:ring-brand-primary">
                                    <span class="font-bold text-sm">Allow Voting</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Enable or disable the agree/disagree voting system.</p>
                            </div>
                        </div>

                    {{-- API SETTINGS --}}
                    @elseif($group === 'api')
                        <h2 class="text-xl font-bold mb-6 pb-4 border-b border-white/10 flex items-center gap-2">
                            <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            API & Integrations
                        </h2>

                        <!-- AI Section -->
                        <div class="mb-8 p-6 bg-gradient-to-r from-violet-500/10 to-fuchsia-500/10 rounded-xl border border-violet-500/20">
                            <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-violet-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                AI Configuration (OpenAI)
                            </h3>
                            <p class="text-gray-400 text-sm mb-4">Power AI summaries and vibe tags with OpenAI's GPT models.</p>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">OpenAI API Key</label>
                                <div class="relative">
                                    <input wire:model="settings.openai_api_key" type="password" placeholder="sk-..." class="w-full bg-black/30 border border-white/10 rounded-lg p-3 text-white pr-24 font-mono text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-500">
                                    <button type="button" wire:click="testOpenAI" wire:loading.attr="disabled" class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-violet-600 hover:bg-violet-500 text-white text-xs font-bold rounded-lg transition-colors">
                                        <span wire:loading.remove wire:target="testOpenAI">Test</span>
                                        <span wire:loading wire:target="testOpenAI">...</span>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Get your API key from <a href="https://platform.openai.com/api-keys" target="_blank" class="text-violet-400 hover:underline">platform.openai.com</a></p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Model</label>
                                <select wire:model="settings.openai_model" class="w-full bg-black/30 border border-white/10 rounded-lg p-3 text-white focus:border-violet-500 focus:ring-1 focus:ring-violet-500">
                                    <option value="gpt-4o-mini">GPT-4o Mini (Fast & Cheap)</option>
                                    <option value="gpt-4o">GPT-4o (Best Quality)</option>
                                    <option value="gpt-4-turbo">GPT-4 Turbo</option>
                                    <option value="gpt-3.5-turbo">GPT-3.5 Turbo (Legacy)</option>
                                </select>
                            </div>

                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.ai_enabled" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-violet-500 focus:ring-violet-500">
                                    <span class="font-bold text-sm">Enable AI Features</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">When disabled, AI summaries will use mock/template data.</p>
                            </div>
                        </div>

                        <!-- Domain Checker Section -->
                        <div class="mb-6 p-6 bg-gradient-to-r from-emerald-500/10 to-cyan-500/10 rounded-xl border border-emerald-500/20">
                            <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-emerald-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                Domain Checker (GoDaddy Affiliate)
                            </h3>
                            <p class="text-gray-400 text-sm mb-4">Earn commission when users buy domains through your affiliate link.</p>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">GoDaddy Affiliate ID</label>
                                <input wire:model="settings.godaddy_affiliate_id" type="text" placeholder="your-affiliate-id" class="w-full bg-black/30 border border-white/10 rounded-lg p-3 text-white font-mono text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                <p class="text-xs text-gray-500 mt-2">Join GoDaddy's affiliate program at <a href="https://www.godaddy.com/affiliate-programs" target="_blank" class="text-emerald-400 hover:underline">godaddy.com/affiliate-programs</a></p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Domain TLDs to Check</label>
                                <input wire:model="settings.domain_tlds" type="text" placeholder="com,io,co,xyz" class="w-full bg-black/30 border border-white/10 rounded-lg p-3 text-white font-mono text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                <p class="text-xs text-gray-500 mt-2">Comma-separated list of TLDs to show in domain checker.</p>
                            </div>

                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.domain_checker_enabled" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-emerald-500 focus:ring-emerald-500">
                                    <span class="font-bold text-sm">Enable Domain Checker</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Show domain availability checker on word pages.</p>
                            </div>
                        </div>

                    {{-- MODERATION SETTINGS --}}
                    @elseif($group === 'moderation')
                        <h2 class="text-xl font-bold mb-6 pb-4 border-b border-white/10 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Moderation Settings
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.auto_approve_definitions" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary focus:ring-brand-primary">
                                    <span class="font-bold text-sm">Auto-Approve Definitions</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Automatically approve new definitions without review.</p>
                            </div>

                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.require_login_to_submit" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary focus:ring-brand-primary">
                                    <span class="font-bold text-sm">Require Login to Submit</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Users must be logged in to submit words/definitions.</p>
                            </div>

                            <div class="p-4 bg-black/20 rounded-lg border border-white/10">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input wire:model="settings.spam_filter_enabled" type="checkbox" value="true" class="w-5 h-5 rounded bg-gray-700 border-gray-600 text-brand-primary focus:ring-brand-primary">
                                    <span class="font-bold text-sm">Spam Filter</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2 pl-8">Enable basic spam detection on submissions.</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Max Definitions Per Day (Per User)</label>
                            <input wire:model="settings.max_definitions_per_day" type="number" min="1" max="100" class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white focus:border-brand-accent focus:ring-1 focus:ring-brand-accent">
                            <p class="text-xs text-gray-500 mt-2">Limit how many definitions a user can submit per day.</p>
                        </div>

                    @endif

                    <div class="flex justify-end pt-6 border-t border-white/10">
                        <button type="submit" class="px-6 py-2.5 bg-green-500 text-white font-bold rounded-lg hover:bg-green-400 transition-colors shadow-lg shadow-green-500/20 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
