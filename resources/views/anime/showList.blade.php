<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $animeList->name }}
            </h2>
            <div class="flex space-x-2">
                <button
                    x-data="{}"
                    x-on:click="$dispatch('open-modal', 'edit-anime-list')"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit List
                </button>
                <form action="{{ route('anime-lists.destroy', $animeList) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" 
                            onclick="return confirm('Are you sure you want to delete this list?')">
                        Delete List
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- List Details Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    @if($animeList->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Description</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $animeList->description }}</p>
                        </div>
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <span>Created: {{ $animeList->created_at->format('M d, Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $animeCount }} {{ Str::plural('anime', $animeCount) }}</span>
                            <!-- Add favorite count here -->
                            <span class="mx-2">•</span>
                            <div class="inline-flex items-center">
                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span>{{ $animeList->favoritedBy->count() }} favorites</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Anime Grid Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Animes in this list</h3>
                    
                    @if($animeCount > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($animes as $anime)
                                <x-card
                                    image="{{ $anime->image_url ?? null }}"
                                    imageAlt="{{ $anime->title }}"
                                    title="{{ $anime->title }}"
                                >
                                    <div class="mt-4 flex flex-col gap-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                            {{ Str::limit($anime->description ?? '', 80) }}
                                        </p>
                                        
                                        <div class="mt-auto flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <a href="{{ route('anime.show', $anime->mal_id) }}" 
                                               class="text-blue-500 hover:text-blue-700 font-medium text-sm flex items-center">
                                                <span>View details</span>
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('anime-lists.remove-anime', ['animeList' => $animeList->id, 'anime' => $anime->id]) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to remove this anime from the list?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    <span>Remove</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">This list doesn't have any anime yet.</p>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Add anime from the browse page to get started!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Comments Section -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Discussion</h3>
                    
                    @auth
                        <!-- Comment Form -->
                        <div class="mb-6">
                            <form action="{{ route('comments.store', $animeList) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea 
                                        name="content"
                                        rows="3"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                        placeholder="Add a comment..."
                                        required
                                    ></textarea>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a> to join the discussion.
                            </p>
                        </div>
                    @endauth
                    
                    <!-- Comments List -->
                    @if(isset($comments) && $comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($comments as $comment)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0">
                                    <div class="flex items-start mb-2">
                                        <div class="flex-shrink-0">
                                            @if($comment->user->profile_picture)
                                                <img src="{{ Storage::url($comment->user->profile_picture) }}" alt="{{ $comment->user->name }}" 
                                                     class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                    <span class="text-gray-600 dark:text-gray-300">{{ substr($comment->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="ml-3 flex-grow">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <a href="{{ route('users.show', $comment->user) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                        {{ $comment->user->name }}
                                                    </a>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                
                                                @if(Auth::id() === $comment->user_id || Auth::id() === $animeList->user_id)
                                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            
                                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                                            
                                            @auth
                                                <button
                                                    x-data="{}"
                                                    x-on:click="$dispatch('open-modal', 'reply-to-comment-{{ $comment->id }}')"
                                                    class="text-xs text-blue-500 hover:text-blue-700 mt-2">
                                                    Reply
                                                </button>
                                                
                                                <!-- Reply Modal -->
                                                <x-modal name="reply-to-comment-{{ $comment->id }}" :show="false">
                                                    <div class="p-6">
                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                                            Reply to {{ $comment->user->name }}
                                                        </h2>
                                                        
                                                        <form action="{{ route('comments.store', $animeList) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                            
                                                            <div class="mb-3">
                                                                <textarea 
                                                                    name="content"
                                                                    rows="3"
                                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                                                    placeholder="Write your reply..."
                                                                    required
                                                                ></textarea>
                                                            </div>
                                                            
                                                            <div class="flex justify-end">
                                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                                    {{ __('Cancel') }}
                                                                </x-secondary-button>
                                                                
                                                                <x-primary-button class="ml-3">
                                                                    {{ __('Post Reply') }}
                                                                </x-primary-button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </x-modal>
                                            @endauth
                                            
                                            <!-- Comment Replies -->
                                            @if($comment->replies->count() > 0)
                                                <div class="ml-6 mt-3 border-l-2 border-gray-200 dark:border-gray-700 pl-4 space-y-3">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="pb-3 last:pb-0">
                                                            <div class="flex items-start">
                                                                <div class="flex-shrink-0">
                                                                    @if($reply->user->profile_picture)
                                                                        <img src="{{ Storage::url($reply->user->profile_picture) }}" alt="{{ $reply->user->name }}" 
                                                                             class="h-8 w-8 rounded-full object-cover">
                                                                    @else
                                                                        <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                                            <span class="text-gray-600 dark:text-gray-300 text-sm">{{ substr($reply->user->name, 0, 1) }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="ml-3 flex-grow">
                                                                    <div class="flex items-center justify-between">
                                                                        <div>
                                                                            <a href="{{ route('users.show', $reply->user) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                                                {{ $reply->user->name }}
                                                                            </a>
                                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                                {{ $reply->created_at->diffForHumans() }}
                                                                            </p>
                                                                        </div>
                                                                        
                                                                        @if(Auth::id() === $reply->user_id || Auth::id() === $animeList->user_id)
                                                                            <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs" onclick="return confirm('Are you sure you want to delete this reply?')">
                                                                                    Delete
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ $reply->content }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Anime List Modal -->
    <x-modal name="edit-anime-list" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Anime List') }}
            </h2>
            
            <form method="POST" action="{{ route('anime-lists.update', $animeList) }}" class="mt-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" :value="__('List Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus :value="$animeList->name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="A short description of your anime list..."
                    >{{ $animeList->description }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        {{ __('Save Changes') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
