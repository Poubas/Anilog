<x-noauth-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Anime Image -->
                        <div class="flex-none w-full md:w-64">
                            <img 
                                src="{{ $anime['images']['jpg']['large_image_url'] ?? $anime['images']['jpg']['image_url'] ?? '' }}" 
                                alt="{{ $anime['title'] }}" 
                                class="w-full rounded-lg shadow-md"
                            >
                            
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($anime['genres'] ?? [] as $genre)
                                    <span class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 text-xs rounded">
                                        {{ $genre['name'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Anime Details -->
                        <div class="flex-grow">
                            <div class="flex items-center mb-4">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $anime['title'] }}</h1>
                                @if($anime['score'])
                                    <div class="ml-auto flex items-center bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="font-bold">{{ $anime['score'] }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            @if($anime['title_japanese'])
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    {{ $anime['title_japanese'] }}
                                </div>
                            @endif
                            
                            <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                                <div>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Type:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $anime['type'] ?? 'Unknown' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Episodes:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $anime['episodes'] ?? 'Unknown' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Status:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $anime['status'] ?? 'Unknown' }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Aired:</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ $anime['aired']['string'] ?? 'Unknown' }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Synopsis</h3>
                                <p class="text-gray-700 dark:text-gray-300">
                                    {{ $anime['synopsis'] ?? 'No synopsis available.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Call to action for guests -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Want to track this anime?</h3>
                    
                    <div class="text-center border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-6">
                        <p class="text-gray-500 dark:text-gray-400">
                            Create an account to track this anime and build your own collection.
                        </p>
                        <div class="mt-6 flex justify-center gap-4">
                            <a href="{{ route('login') }}" class="px-5 py-2 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                                Login
                            </a>

                            <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md transition duration-150 ease-in-out">
                                Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            @if($reviews->count() > 0)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Community Reviews</h3>
                        
                        @if($reviewStats)
                            <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-2xl font-bold">{{ $reviewStats['percentage'] }}%</span>
                                        <span class="text-gray-600 dark:text-gray-400 ml-2">positive reviews</span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                            </svg>
                                            <span class="ml-1">{{ $reviewStats['positive'] }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                                            </svg>
                                            <span class="ml-1">{{ $reviewStats['negative'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Call to action for reviews -->
                        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a> to leave your own review.
                            </p>
                        </div>
                        
                        <!-- Reviews List -->
                        <div class="space-y-4">
                            @foreach($reviews as $review)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                @if($review->user->profile_picture)
                                                    <img src="{{ Storage::url($review->user->profile_picture) }}" alt="{{ $review->user->name }}" 
                                                         class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                        <span class="text-gray-600 dark:text-gray-300">{{ substr($review->user->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $review->user->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $review->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="{{ $review->is_positive ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }} flex items-center px-2 py-1 rounded-full text-xs font-medium">
                                            @if($review->is_positive)
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                                </svg>
                                                Liked
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                                                </svg>
                                                Disliked
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $review->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-noauth-layout>