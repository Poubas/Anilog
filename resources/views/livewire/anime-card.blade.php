<div class="max-w-sm rounded-lg overflow-hidden shadow-lg bg-white dark:bg-zinc-900">
    <img class="w-full h-64 object-cover" src="{{ $anime['images']['jpg']['image_url'] }}" alt="{{ $anime['title'] }}">

    <div class="p-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $anime['title'] }}</h2>
        <p class="text-gray-600 dark:text-gray-300 text-sm mt-2">{{ $anime['synopsis'] ? Str::limit($anime['synopsis'], 150) : 'No synopsis available.' }}</p>

        <div class="mt-4 flex justify-between items-center">
            <span class="text-sm text-gray-500 dark:text-gray-400">Episodes: {{ $anime['episodes'] ?? 'N/A' }}</span>
            <span class="text-sm text-gray-500 dark:text-gray-400">Score: {{ $anime['score'] ?? 'N/A' }}</span>
        </div>

        <a href="{{ $anime['url'] }}" target="_blank" class="mt-4 inline-block text-blue-500 hover:text-blue-700 text-sm font-semibold">
            View on MyAnimeList →
        </a>
    </div>
</div>
