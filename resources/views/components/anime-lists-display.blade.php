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
        @forelse($lists as $list)
            <x-card
                class="h-full flex flex-col"
                title="{{ $list->name }}"
                description="{{ $list->description ?? '' }}"
            >
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $list->anime_count }} {{ Str::plural('anime', $list->anime_count) }}
                    </span>
                    <a href="{{ route('anime-lists.show', $list) }}" 
                       class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300 text-sm font-medium rounded-md hover:bg-blue-200 dark:hover:bg-blue-700 transition">
                        View list
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </x-card>
        @empty
            <div class="col-span-full p-6 text-center border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">You haven't created any anime lists yet.</p>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Click the "Create List" button to get started!</p>
            </div>
        @endforelse
    </div>
</div>