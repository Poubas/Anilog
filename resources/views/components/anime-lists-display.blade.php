<!-- filepath: /home/magro/facul/anilog/anilog-app/resources/views/components/anime-lists-display.blade.php -->
<div>
    <!-- At the top of resources/views/components/anime-lists-display.blade.php -->
<div>
    @if(isset($lists))
        <!-- For debugging -->
        <p class="text-sm text-gray-500 mb-4">Found: {{ $lists->count() }} lists</p>
    @else
        <p class="text-sm text-red-500 mb-4">Lists variable not available</p>
    @endif
    
    <!-- Rest of your component code -->
</div>
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ __('My Anime Lists') }}
        </h3>
        
        <button 
            x-data="{}"
            x-on:click="$dispatch('open-modal', 'create-anime-list')"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
            {{ __('Create List') }}
        </button>
    </div>
    
    <!-- Anime Lists Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse(auth()->user()->animeLists as $list)
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
                
                <!-- Content Section -->
                <div class="p-5">
                    <!-- Title and Anime Count -->
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-white truncate" title="{{ $list->name }}">
                            {{ $list->name }}
                        </h4>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                            @php
                                $animeCount = DB::table('anime_list_anime')
                                    ->where('anime_list_id', $list->id)
                                    ->count();
                            @endphp
                            {{ $animeCount }} {{ Str::plural('anime', $animeCount) }}
                        </span>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2" title="{{ $list->description }}">
                        {{ $list->description ?? 'No description available.' }}
                    </p>
                    
                    <!-- Card Footer -->
                    <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                        <div>
                            <span>By: {{ auth()->user()->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span>{{ $list->favoritedBy->count() }} favorites</span>
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="{{ route('anime-lists.show', $list) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                        View List
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">You haven't created any lists yet.</p>
                <button
                    x-data="{}"
                    x-on:click="$dispatch('open-modal', 'create-anime-list')"
                    class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    Create Your First List
                </button>
            </div>
        @endforelse
    </div>
</div>