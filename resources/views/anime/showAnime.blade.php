<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $anime['title'] }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
            
            <!-- Action buttons -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Add to List</h3>
                    
                    @auth
                        @if(isset($userLists) && $userLists->count() > 0)
                            <form action="{{ route('anime-lists.add-anime') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                                <input type="hidden" name="anime_title" value="{{ $anime['title'] }}">
                                <input type="hidden" name="anime_image" value="{{ $anime['images']['jpg']['image_url'] ?? '' }}">
                                
                                <div>
                                    <x-input-label for="list_id" :value="__('Select a list')" />
                                    <select id="list_id" name="list_id" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1">
                                        @foreach($userLists as $list)
                                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <x-primary-button type="submit">
                                        Add to List
                                    </x-primary-button>
                                </div>
                            </form>
                        @else
                            <div class="text-center border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-6">
                                <p class="text-gray-500 dark:text-gray-400">
                                    You don't have any anime lists yet.
                                </p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Create a list</a> to start adding anime!
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="text-center border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-6">
                            <p class="text-gray-500 dark:text-gray-400">
                                You need to be logged in to add anime to your lists.
                            </p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a> or 
                                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">register</a> to get started!
                            </p>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Reviews</h3>
                    
                    @if($reviewStats)
                        <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $reviewStats['percentage'] }}%</span>
                                    <span class="text-gray-600 dark:text-gray-400 ml-2">positive reviews</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                        </svg>
                                        <span class="ml-1 text-gray-900 dark:text-gray-100">{{ $reviewStats['positive'] }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                                        </svg>
                                        <span class="ml-1 text-gray-900 dark:text-gray-100">{{ $reviewStats['negative'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @auth
                        <!-- Review Form -->
                        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">
                                {{ $userReview ? 'Edit your review' : 'Write a review' }}
                            </h4>

                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="anime_id" value="{{ $dbAnime->id ?? '' }}">
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your rating:</label>
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="is_positive" value="1" class="form-radio text-blue-600" 
                                                {{ $userReview && $userReview->is_positive ? 'checked' : '' }} required>
                                            <svg class="w-5 h-5 text-green-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                            </svg>
                                            <span class="ml-1 text-sm text-gray-300">Like</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="is_positive" value="0" class="form-radio text-red-600" 
                                                {{ $userReview && !$userReview->is_positive ? 'checked' : '' }} required>
                                            <svg class="w-5 h-5 text-red-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"></path>
                                            </svg>
                                            <span class="ml-1 text-sm text-gray-300">Dislike</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your review:</label>
                                    <textarea 
                                        id="content" 
                                        name="content"
                                        rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                        placeholder="Share your thoughts about this anime..."
                                        required
                                    >{{ $userReview ? $userReview->content : '' }}</textarea>
                                </div>
                                
                                <div class="flex justify-end">
                                    @if($userReview)
                                        <form action="{{ route('reviews.destroy', $userReview) }}" method="POST" class="mr-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                        {{ $userReview ? 'Update Review' : 'Submit Review' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a> to leave a review.
                            </p>
                        </div>
                    @endauth
                    
                    <!-- Reviews List -->
                    @if($reviews->count() > 0)
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
                                                <a href="{{ route('users.show', $review->user) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                    {{ $review->user->name }}
                                                </a>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $review->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="{{ $review->is_positive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} flex items-center px-2 py-1 rounded-full text-xs font-medium">
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
                    @else
                        <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">No reviews yet. Be the first to review!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
