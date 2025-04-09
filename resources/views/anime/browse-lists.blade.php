<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Browse Community Anime Lists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Filter and Sort Options -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 md:mb-0">
                            {{ __('Discover Anime Lists') }}
                        </h3>
                        
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Sort by:</span>
                            <form action="{{ route('anime-lists.browse') }}" method="GET" class="inline-flex">
                                <select name="sort" onchange="this.form.submit()" 
                                    class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm py-1 px-3 text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                    <option value="alphabetical" {{ $sort == 'alphabetical' ? 'selected' : '' }}>A-Z</option>
                                    <option value="most_anime" {{ $sort == 'most_anime' ? 'selected' : '' }}>Most Anime</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Lists Grid -->
                    @if($communityLists->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($communityLists as $list)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                    <!-- Image Section -->
                                    @if($list->image)
                                        <div class="h-48 overflow-hidden">
                                            <img src="{{ Storage::url($list->image) }}" 
                                                 alt="{{ $list->name }}" 
                                                 class="w-full h-full object-cover"
                                            >
                                        </div>
                                    @else
                                        <div class="h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-gray-400 dark:text-gray-500 text-4xl">
                                                {{ substr($list->name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div class="p-5">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4 class="font-bold text-lg text-gray-900 dark:text-white truncate" title="{{ $list->name }}">
                                                {{ $list->name }}
                                            </h4>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                {{ $list->anime_count }} {{ Str::plural('anime', $list->anime_count) }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2" title="{{ $list->description }}">
                                            {{ $list->description ?? 'No description available.' }}
                                        </p>
                                        
                                        <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                                            <span>By: <a href="{{ route('users.show', $list->user) }}" class="text-blue-500 hover:underline">{{ $list->user->name }}</a></span>
                                            
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                <span>{{ $list->favoritedBy->count() }} favorites</span>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('community.anime-lists.show', $list) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                                            View List
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $communityLists->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">No anime lists found.</p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Be the first to create an anime list!</p>
                            
                            <a href="{{ route('dashboard') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                Create a List
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
