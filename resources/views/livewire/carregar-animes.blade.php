<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">Anime List</h1>

    <!-- Anime Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($animeList as $anime)
            <livewire:anime-card :anime="$anime" :key="$anime['mal_id']" />
        @endforeach
    </div>

    <!-- Pagination Controls -->
    <div class="mt-6 flex justify-center">
        <button wire:click="previousPage" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-md mr-2 disabled:opacity-50" @if($page == 1) disabled @endif>
            Previous
        </button>
        <button wire:click="nextPage" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-md disabled:opacity-50">
            Next
        </button>
    </div>
</div>
