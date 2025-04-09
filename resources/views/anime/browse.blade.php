<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Explore Anime</h1>

        <form method="GET" action="{{ route('anime.browse') }}" class="mb-8">
            <div class="flex flex-col md:flex-row gap-2 mb-4">
                <input 
                    type="text" 
                    name="query" 
                    value="{{ $query }}" 
                    placeholder="Search anime..." 
                    class="border border-gray-300 dark:border-gray-700 rounded-md p-2 w-full dark:bg-gray-800 dark:text-white"
                >
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out md:w-auto w-full"
                >
                    Search
                </button>
            </div>
            
            <!-- Sort and Filter Options -->
            <div x-data="{ isOpen: false }" class="mt-4">
                <button 
                    @click.prevent="isOpen = !isOpen" 
                    type="button"
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-left text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-gray-500 focus-visible:ring-opacity-75"
                >
                    <span>Sort and Filter Options</span>
                    <svg 
                        class="w-5 h-5 transform transition-transform duration-150" 
                        :class="{'rotate-180': isOpen}"
                        fill="currentColor" 
                        viewBox="0 0 20 20"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div 
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="mt-2 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg"
                >
                    @if(empty($query))
                    <!-- Notice to show when no query is present -->
                    <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                    Enter a search query to enable all filter options. Currently, only popularity filters are available.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Sort Options -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort by:</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($sortOptions as $value => $label)
                                <label 
                                    class="px-3 py-1 text-sm rounded-full cursor-pointer 
                                        {{ empty($query) && !in_array($value, ['popularity', 'score']) 
                                            ? 'bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed opacity-60'
                                            : ($sort === $value 
                                                ? 'bg-blue-600 text-white' 
                                                : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600') 
                                        }} transition duration-150 ease-in-out"
                                >
                                    <input 
                                        type="radio" 
                                        name="sort" 
                                        value="{{ $value }}" 
                                        {{ $sort === $value ? 'checked' : '' }}
                                        {{ empty($query) && !in_array($value, ['popularity', 'score']) ? 'disabled' : '' }}
                                        class="hidden"
                                    >
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Sort Direction -->
                    <div class="mb-4 {{ empty($query) ? 'opacity-60' : '' }}">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Direction:</label>
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <label 
                                class="px-4 py-2 text-sm font-medium cursor-pointer 
                                    {{ empty($query) ? 'cursor-not-allowed ' : '' }}
                                    {{ $direction === 'desc' 
                                        ? 'bg-blue-600 text-white' 
                                        : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-l-lg border-r border-gray-300 dark:border-gray-600"
                            >
                                <input 
                                    type="radio" 
                                    name="direction" 
                                    value="desc" 
                                    {{ $direction === 'desc' ? 'checked' : '' }}
                                    {{ empty($query) ? 'disabled' : '' }}
                                    class="hidden"
                                >
                                Descending
                            </label>
                            
                            <label 
                                class="px-4 py-2 text-sm font-medium cursor-pointer 
                                    {{ empty($query) ? 'cursor-not-allowed ' : '' }}
                                    {{ $direction === 'asc' 
                                        ? 'bg-blue-600 text-white' 
                                        : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-r-lg"
                            >
                                <input 
                                    type="radio" 
                                    name="direction" 
                                    value="asc" 
                                    {{ $direction === 'asc' ? 'checked' : '' }}
                                    {{ empty($query) ? 'disabled' : '' }}
                                    class="hidden"
                                >
                                Ascending
                            </label>
                        </div>
                    </div>
                    
                    <!-- Genre Filter -->
                    <div class="{{ empty($query) ? 'opacity-60' : '' }}">
                        <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Genre</label>
                        
                        <!-- Include Genres Section -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Include Genres:</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($genres as $genre)
                                    <label 
                                        class="px-3 py-1 text-xs rounded-full cursor-pointer 
                                            {{ empty($query) ? 'cursor-not-allowed ' : '' }}
                                            {{ in_array($genre['id'], $selectedGenres) 
                                                ? 'bg-blue-600 text-white' 
                                                : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition duration-150 ease-in-out"
                                    >
                                        <input 
                                            type="checkbox" 
                                            name="genres[]" 
                                            value="{{ $genre['id'] }}" 
                                            {{ in_array($genre['id'], $selectedGenres) ? 'checked' : '' }}
                                            {{ empty($query) ? 'disabled' : '' }}
                                            class="hidden"
                                        >
                                        {{ $genre['name'] }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Exclude Genres Section -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Exclude Genres:</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($genres as $genre)
                                    <label 
                                        class="px-3 py-1 text-xs rounded-full cursor-pointer 
                                            {{ empty($query) ? 'cursor-not-allowed ' : '' }}
                                            {{ in_array($genre['id'], $excludedGenres) 
                                                ? 'bg-red-600 text-white' 
                                                : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition duration-150 ease-in-out"
                                    >
                                        <input 
                                            type="checkbox" 
                                            name="excluded_genres[]" 
                                            value="{{ $genre['id'] }}" 
                                            {{ in_array($genre['id'], $excludedGenres) ? 'checked' : '' }}
                                            {{ empty($query) ? 'disabled' : '' }}
                                            class="hidden"
                                        >
                                        {{ $genre['name'] }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Buttons in their own div without opacity restriction -->
                    <div class="mt-6 flex justify-end">
                        <button 
                            type="submit" 
                            class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-150 ease-in-out"
                        >
                            Apply Filters
                        </button>
                        
                        @if(!empty($selectedGenres) || !empty($excludedGenres) || $sort !== 'score' || $direction !== 'desc')
                            <a 
                                href="{{ route('anime.browse') }}{{ !empty($query) ? '?query=' . $query : '' }}" 
                                class="ml-2 px-4 py-2 text-sm bg-gray-600 hover:bg-gray-700 text-white rounded-md transition duration-150 ease-in-out"
                            >
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                </div>
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
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Try different terms or filters.</p>
            </div>
        @endif
    </div>

    <script>
        // Add active class to buttons when clicked
        document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', function() {
                if (this.type === 'radio') {
                    // For radio buttons (sort and direction)
                    const name = this.name;
                    document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                        const parent = radio.parentElement;
                        if (radio.checked) {
                            parent.classList.add('bg-blue-600', 'text-white');
                            parent.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        } else {
                            parent.classList.remove('bg-blue-600', 'text-white');
                            parent.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        }
                    });
                } else {
                    // For checkboxes (genres)
                    const parent = this.parentElement;
                    if (this.checked) {
                        if (this.name === 'genres[]') {
                            parent.classList.add('bg-blue-600', 'text-white');
                            parent.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        } else {
                            parent.classList.add('bg-red-600', 'text-white');
                            parent.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        }
                    } else {
                        if (this.name === 'genres[]') {
                            parent.classList.remove('bg-blue-600', 'text-white');
                        } else {
                            parent.classList.remove('bg-red-600', 'text-white');
                        }
                        parent.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                    }
                }
            });
        });
    </script>
</x-app-layout>