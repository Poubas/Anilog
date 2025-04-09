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
        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
            @if($anime->image_url)
                <img src="{{ $anime->image_url }}" alt="{{ $anime->title }}" class="w-full h-48 object-cover">
            @else
                <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <span class="text-4xl font-bold text-white">{{ strtoupper(substr($anime->title, 0, 1)) }}</span>
                </div>
            @endif
            
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 truncate" title="{{ $anime->title }}">
                    {{ $anime->title }}
                </h3>
                
                <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2 mb-4">
                    {{ Str::limit($anime->synopsis ?? 'No description available.', 100) }}
                </p>
                
                <a href="{{ route('anime.show', $anime->mal_id) }}" 
                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                    View Details
                </a>
            </div>
        </div>
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
                    <input type="hidden" name="parent_id" value="" id="reply_to_id">
                    <div class="mb-3">
                        <textarea 
                            name="content"
                            rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                            placeholder="Add a comment..."
                            required
                            id="comment_content"
                        ></textarea>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div id="reply_indicator" class="text-sm text-gray-500 dark:text-gray-400 hidden">
                            <span>Replying to: </span>
                            <span id="reply_to_user" class="font-medium"></span>
                            <button type="button" onclick="cancelReply()" class="ml-2 text-red-500 hover:text-red-600">
                                Cancel
                            </button>
                        </div>
                        
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
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0" id="comment-{{ $comment->id }}">
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
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                
                                <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                                
                                @auth
                                    <button
                                        type="button"
                                        onclick="setReplyTo({{ $comment->id }}, '{{ $comment->user->name }}')"
                                        class="text-xs text-blue-500 hover:text-blue-700 mt-2">
                                        Reply
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Show Replies -->
                    @foreach($comment->replies as $reply)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0 ml-6" id="comment-{{ $reply->id }}">
                            <div class="flex items-start mb-2">
                                <div class="flex-shrink-0">
                                    @if($reply->user->profile_picture)
                                        <img src="{{ Storage::url($reply->user->profile_picture) }}" alt="{{ $reply->user->name }}" 
                                             class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-gray-600 dark:text-gray-300">{{ substr($reply->user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="ml-3 flex-grow">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <a href="{{ route('users.show', $reply->user) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:underline">
                                                {{ $reply->user->name }}
                                            </a>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mx-1">•</span>
                                            <a href="#comment-{{ $comment->id }}" class="text-xs text-blue-500 hover:underline">
                                                @replying to {{ $comment->user->name }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $reply->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        
                                        @if(Auth::id() === $reply->user_id || Auth::id() === $animeList->user_id)
                                            <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    
                                    <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $reply->content }}</p>
                                    
                                    @auth
                                        <button
                                            type="button"
                                            onclick="setReplyTo({{ $comment->id }}, '{{ $comment->user->name }}')"
                                            class="text-xs text-blue-500 hover:text-blue-700 mt-2">
                                            Reply
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @else
            <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</p>
            </div>
        @endif
    </div>
</div>

<script>
    function setReplyTo(commentId, userName) {
        document.getElementById('reply_to_id').value = commentId;
        document.getElementById('reply_to_user').textContent = userName;
        document.getElementById('reply_indicator').classList.remove('hidden');
        document.getElementById('comment_content').focus();
        document.getElementById('comment_content').placeholder = `Reply to ${userName}...`;
        
        // Scroll to comment form
        const commentForm = document.getElementById('comment_content');
        commentForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    function cancelReply() {
        document.getElementById('reply_to_id').value = '';
        document.getElementById('reply_indicator').classList.add('hidden');
        document.getElementById('comment_content').placeholder = 'Add a comment...';
    }
</script>
        </div>
    </div>

    @if($isOwner)
        <!-- Edit Anime List Modal -->
        <x-modal name="edit-anime-list" :show="false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Edit Anime List') }}
                </h2>
                
                <form method="POST" action="{{ route('anime-lists.update', $animeList) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
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

                    <!-- Image Upload -->
                    <div>
                        <x-input-label for="image" :value="__('Cover Image')" />
                        
                        @if($animeList->image)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Current image:</p>
                                <img src="{{ Storage::url($animeList->image) }}" alt="Current cover" class="h-32 object-cover rounded mt-1">
                            </div>
                        @endif
                        
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                dark:file:bg-gray-700 dark:file:text-gray-200
                                dark:hover:file:bg-gray-600"
                        />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Upload a new cover image for your list (optional)
                        </p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
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