<!-- filepath: /home/magro/facul/anilog/anilog-app/resources/views/components/anime-card.blade.php -->
<div class="max-w-sm rounded overflow-hidden shadow-lg m-4 flex flex-col">
    <img class="w-full h-64 object-cover rounded-t" src="{{ $image }}" alt="{{ $title }}">
    <div class="px-6 py-4 bg-gray-800 text-white flex-grow flex flex-col">
        <div class="font-bold text-xl mb-2 truncate" title="{{ $title }}">{{ $title }}</div>
        <p class="text-gray-300 text-base mb-4 flex-grow">
            {{ $description }}
        </p>
        <div class="mt-auto">
            <a href="{{ route('anime.show', $animeId) }}" 
               class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full text-center transition duration-150 ease-in-out">
                View Details
            </a>
        </div>
    </div>
</div>