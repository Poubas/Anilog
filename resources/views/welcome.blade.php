<x-noauth-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Welcome to AniLog</h1>

        <p class="mb-6 text-gray-600 dark:text-gray-300">Discover and track your favorite anime series</p>

        @if (isset($animes) && count($animes) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($animes as $anime)
                    <x-guest-anime-card :title="$anime['title']" :description="$anime['synopsis'] ?? ''" :image="$anime['images']['jpg']['image_url'] ?? ''" :animeId="$anime['mal_id']" />
                @endforeach
            </div>

            @if (isset($paginator))
                <div class="mt-8">
                    {{ $paginator->links() }}
                </div>
            @endif
        @else
            <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">Welcome to AniLog!</p>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Create an account to start tracking your favorite anime.</p>

                <div class="mt-6 flex justify-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-150 ease-in-out">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md transition duration-150 ease-in-out">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-noauth-layout>
