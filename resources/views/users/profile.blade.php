<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $user->name }}'s Profile
            </h2>
            
            @if($isOwnProfile)
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
                    Edit Profile
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row">
                        <!-- Profile Picture -->
                        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                            @if ($user->profile_picture)
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile Picture" 
                                     class="rounded-full h-32 w-32 object-cover border-4 border-gray-200 dark:border-gray-700">
                            @else
                                <div class="rounded-full h-32 w-32 bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                    <span class="text-gray-600 dark:text-gray-300 text-4xl">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- User Info -->
                        <div class="flex-grow">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $user->name }}
                            </h3>
                            
                            <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span class="font-medium">Member since:</span> 
                                    {{ $user->created_at->format('M d, Y') }}
                                </div>
                                <div>
                                    <span class="font-medium">Lists:</span> 
                                    {{ $lists->count() }}
                                </div>
                                <div>
                                    <span class="font-medium">Total anime:</span> 
                                    {{ $totalAnime }}
                                </div>
                            </div>
                            
                            <!-- User Bio Section -->
                            <div class="mt-4">
                                <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">About {{ $user->name }}</h4>
                                <p class="mt-2 text-gray-700 dark:text-gray-300">
                                    {{ $user->bio ?? 'This user has not added a bio yet.' }}
                                </p>
                            </div>
                            
                            <!-- Follow/Unfollow Button Section - ADD THIS PART -->
                            @if(Auth::check() && !$isOwnProfile)
                                <div class="mt-4 flex items-center">
                                    @if(Auth::user()->isFollowing($user))
                                        <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                                </svg>
                                                Unfollow
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('users.follow', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Follow
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <!-- Followers/Following Stats -->
                                    <div class="ml-4 flex space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                        <div>
                                            <span class="font-medium">{{ $user->followers()->count() }}</span> Followers
                                        </div>
                                        <div>
                                            <span class="font-medium">{{ $user->following()->count() }}</span> Following
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- End Follow/Unfollow Button Section -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User's Anime Lists Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">
                        {{ $user->name }}'s Anime Lists
                    </h3>
                    
                    @if($lists->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($lists as $list)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                    <!-- Image Section -->
                                    @if($list->image)
                                        <div class="h-48 overflow-hidden">
                                            <img src="{{ Storage::url($list->image) }}" 
                                                 alt="{{ $list->name }}" 
                                                 class="w-full h-full object-cover">
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
                                            <span>{{ $list->created_at->format('M d, Y') }}</span>
                                            
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
                    @else
                        <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">{{ $user->name }} hasn't created any anime lists yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>