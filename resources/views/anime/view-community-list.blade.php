<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-2 md:space-y-0">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $animeList->name }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Created by <span class="font-medium">{{ $creator->name }}</span>
                </p>
            </div>
            
            <div class="flex space-x-2">
                @if($isOwner)
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
                @else
                    <a href="{{ route('anime-lists.browse') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back to Lists
                    </a>
                @endif
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
                        </div>
                        
                        <!-- Social sharing options could go here -->
                        @if(Auth::check() && Auth::id() !== $animeList->user_id)
                            <form action="{{ route('anime-lists.toggle-favorite', $animeList) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="flex items-center text-sm {{ Auth::user()->hasFavorited($animeList) ? 'text-yellow-500' : 'text-gray-500' }} hover:text-yellow-500">
                                    <svg class="w-5 h-5 {{ Auth::user()->hasFavorited($animeList) ? 'text-yellow-500 fill-current' : 'text-gray-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <span class="ml-1">{{ Auth::user()->hasFavorited($animeList) ? 'Favorited' : 'Add to Favorites' }}</span>
                                </button>
                            </form>
                        @endif
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
                                            
                                            @if(Auth::check())
                                                <button 
                                                    x-data="{}"
                                                    x-on:click="$dispatch('open-modal', 'add-to-my-list-{{ $anime->id }}')"
                                                    class="text-green-500 hover:text-green-700 font-medium text-sm flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    <span>Add to My List</span>
                                                </button>
                                                
                                                <!-- Modal for adding to user's own list -->
                                                <x-modal name="add-to-my-list-{{ $anime->id }}" :show="false">
                                                    <div class="p-6">
                                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                                            Add "{{ $anime->title }}" to Your List
                                                        </h2>
                                                        
                                                        @if(Auth::user()->animeLists->count() > 0)
                                                            <form action="{{ route('anime-lists.add-anime') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="anime_id" value="{{ $anime->mal_id }}">
                                                                <input type="hidden" name="anime_title" value="{{ $anime->title }}">
                                                                <input type="hidden" name="anime_image" value="{{ $anime->image_url }}">
                                                                
                                                                <div class="mb-4">
                                                                    <x-input-label for="list_id" :value="__('Select a list')" />
                                                                    <select 
                                                                        id="list_id" 
                                                                        name="list_id"
                                                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                                                    >
                                                                        @foreach(Auth::user()->animeLists as $userList)
                                                                            <option value="{{ $userList->id }}">{{ $userList->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="flex justify-end mt-6">
                                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                                        {{ __('Cancel') }}
                                                                    </x-secondary-button>
                                                                    
                                                                    <x-primary-button class="ml-3">
                                                                        {{ __('Add to List') }}
                                                                    </x-primary-button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <div class="text-center py-4">
                                                                <p class="mb-4 text-gray-600 dark:text-gray-400">You don't have any lists yet.</p>
                                                                <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                                                    Create a List First
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </x-modal>
                                            @endif
                                        </div>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">This list doesn't have any anime yet.</p>
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

    @if($isOwner)
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
    @endif
</x-app-layout>