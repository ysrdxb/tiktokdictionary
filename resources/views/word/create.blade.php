<x-layouts.app>
    <x-slot:title>
        Submit a New Word - TikTokDictionary
    </x-slot>

    <!-- Hero Background Section -->
    <div class="w-full bg-[#E9F2FE] pt-32 pb-48 px-6 text-center relative z-10">
        <h1 class="text-[#00336E] font-bold text-4xl md:text-7xl tracking-tighter mb-4 font-title leading-none">
            Submit a New Word
        </h1>
        <p class="text-[#00336E] text-lg md:text-xl font-medium max-w-2xl mx-auto">
            Got a new slang, trend, or phrase? Add it to the dictionary.
        </p>
    </div>

    <!-- Main Content Wrapper (Transparent Container) -->
    <div class="w-full min-h-screen -mt-32 relative z-20 pb-20">
        <!-- Lower Page Global Background (Starts after overlap) -->
        <div class="absolute top-32 bottom-0 left-0 right-0 bg-[#FFFFFF] -z-10"></div>

        <div class="max-w-[1000px] mx-auto px-6">
            @livewire('submit-word-form')
        </div>
    </div>
</x-layouts.app>
