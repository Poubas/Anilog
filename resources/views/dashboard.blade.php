<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4">
                    <div class="flex items-center">
                        <!-- Profile Picture -->
                        <div class="flex-shrink-0 mr-4">
                            @if (Auth::user()->profile_picture)
                                <img src="{{ Storage::url(Auth::user()->profile_picture) }}"
                                    alt="{{ Auth::user()->name }}"
                                    class="h-16 w-16 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                            @else
                                <div
                                    class="h-16 w-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                    <span
                                        class="text-gray-600 dark:text-gray-300 text-2xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- User Quick Info -->
                        <div class="flex-grow">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ Auth::user()->name }}
                            </h3>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span class="font-medium">{{ Auth::user()->animeLists->count() }}</span> Lists
                                </div>
                                <div>
                                    <span class="font-medium">{{ Auth::user()->followers()->count() }}</span> Followers
                                </div>
                                <div>
                                    <span class="font-medium">{{ Auth::user()->following()->count() }}</span> Following
                                </div>
                            </div>
                        </div>

                        <!-- View Profile Button -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('users.show', Auth::user()) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                View My Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg tab-button active border-blue-600 text-blue-600 dark:text-blue-500 dark:border-blue-500"
                            id="lists-tab" 
                            data-tab="lists-content">
                            My Lists
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg tab-button text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-300"
                            id="favorites-tab" 
                            data-tab="favorites-content">
                            Favorites
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 border-transparent rounded-t-lg tab-button text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-300"
                            id="following-tab" 
                            data-tab="following-content">
                            Following
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab contents -->
            <div id="lists-content" class="tab-content active">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <x-anime-lists-display />
                    </div>
                </div>
            </div>

            <div id="favorites-content" class="tab-content hidden">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Your Favorite Lists</h3>

                        @if (auth()->user()->favoriteLists->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach (auth()->user()->favoriteLists as $list)
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                        <!-- Image Section -->
                                        @if ($list->image)
                                            <div class="h-48 overflow-hidden">
                                                <img src="{{ Storage::url($list->image) }}" alt="{{ $list->name }}"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div
                                                class="h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <span class="text-gray-400 dark:text-gray-500 text-4xl">
                                                    {{ substr($list->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Content Section -->
                                        <div class="p-5">
                                            <!-- Title and Anime Count -->
                                            <div class="flex justify-between items-start mb-3">
                                                <h4 class="font-bold text-lg text-gray-900 dark:text-white truncate"
                                                    title="{{ $list->name }}">
                                                    {{ $list->name }}
                                                </h4>
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                    @php
                                                        $animeCount = DB::table('anime_list_anime')
                                                            ->where('anime_list_id', $list->id)
                                                            ->count();
                                                    @endphp
                                                    {{ $animeCount }} {{ Str::plural('anime', $animeCount) }}
                                                </span>
                                            </div>

                                            <!-- Description -->
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 line-clamp-2"
                                                title="{{ $list->description }}">
                                                {{ $list->description ?? 'No description available.' }}
                                            </p>

                                            <!-- Author and Favorites -->
                                            <div
                                                class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                                                <div>
                                                    <span>By: <a href="{{ route('users.show', $list->user) }}"
                                                            class="text-blue-500 hover:underline">{{ $list->user->name }}</a></span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    <span>{{ $list->favoritedBy->count() }} favorites</span>
                                                </div>
                                            </div>

                                            <!-- Action Button -->
                                            <a href="{{ route('community.anime-lists.show', $list) }}"
                                                class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded transition duration-300">
                                                View List
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                                <p class="text-gray-500 dark:text-gray-400">You haven't favorited any lists yet.</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <a href="{{ route('anime-lists.browse') }}"
                                        class="text-blue-500 hover:underline">Browse community lists</a> to find lists
                                    you like!
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div id="following-content" class="tab-content hidden">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Users You're Following
                        </h3>

                        @if (auth()->user()->following->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach (auth()->user()->following as $followedUser)
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                        <div class="p-5 flex items-center">
                                            <!-- User avatar -->
                                            <div class="mr-4 flex-shrink-0">
                                                @if ($followedUser->profile_picture)
                                                    <img src="{{ Storage::url($followedUser->profile_picture) }}"
                                                        class="h-12 w-12 rounded-full object-cover"
                                                        alt="{{ $followedUser->name }}">
                                                @else
                                                    <div
                                                        class="h-12 w-12 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                        <span
                                                            class="text-gray-600 dark:text-gray-300 text-xl">{{ substr($followedUser->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- User info -->
                                            <div class="flex-grow">
                                                <h4 class="font-medium text-gray-900 dark:text-white">
                                                    {{ $followedUser->name }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $followedUser->animeLists->count() }} Lists
                                                </p>
                                            </div>

                                            <!-- View profile button -->
                                            <a href="{{ route('users.show', $followedUser) }}"
                                                class="flex-shrink-0 text-blue-500 hover:text-blue-700">
                                                View Profile
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                                <p class="text-gray-500 dark:text-gray-400">You're not following anyone yet.</p>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <a href="{{ route('anime-lists.browse') }}"
                                        class="text-blue-500 hover:underline">Browse community lists</a> to find users
                                    to follow!
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for tab functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Deactivate all tabs
                    tabButtons.forEach(b => {
                        b.classList.remove('active', 'border-blue-600', 'text-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                        b.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                    });
                    tabContents.forEach(c => c.classList.add('hidden'));
                    
                    // Activate clicked tab
                    button.classList.add('active', 'border-blue-600', 'text-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                    button.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                    const tabId = button.getAttribute('data-tab');
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
    </script>

    <!-- Create Anime List Modal -->
    <x-modal name="create-anime-list" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Create New Anime List') }}
            </h2>

            <form method="POST" action="{{ route('anime-lists.store') }}" class="mt-6 space-y-6"
                enctype="multipart/form-data">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('List Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required
                        autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="A short description of your anime list..."></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Image Upload -->
                <div>
                    <x-input-label for="image" :value="__('Cover Image')" />
                    <input type="file" id="image" name="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                            dark:file:bg-gray-700 dark:file:text-gray-200
                            dark:hover:file:bg-gray-600" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Upload a cover image for your list (optional)
                    </p>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        {{ __('Create List') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
