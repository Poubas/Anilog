<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Browse Anime</h1>

        <form method="GET" action="{{ route('anime.browse') }}" class="mb-8">
            <div class="flex flex-col md:flex-row gap-2">
                <input 
                    type="text" 
                    name="query" 
                    value="{{ $query }}" 
                    placeholder="Search for anime..." 
                    class="border border-gray-300 dark:border-gray-700 rounded-md p-2 w-full dark:bg-gray-800 dark:text-white"
                >
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out md:w-auto w-full"
                >
                    Search
                </button>
            </div>
        </form>

        @if(count($animes) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($animes as $anime)
                    <x-anime-card 
                        :title="$anime['title']" 
                        :description="$anime['synopsis'] ?? ''" 
                        :image="$anime['images']['jpg']['image_url'] ?? ''" 
                        :animeId="$anime['mal_id']"
                    />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $paginator->links() }}
            </div>
        @else
            <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">No anime found matching your search.</p>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Try a different search term or browse popular anime.</p>
            </div>
        @endif
    </div>
</x-app-layout>