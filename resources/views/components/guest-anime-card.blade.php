<div class="relative rounded overflow-hidden shadow-lg flex flex-col h-full bg-white dark:bg-gray-800">
    <!-- Image with overlay gradient -->
    <div class="relative h-52">
        <img class="w-full h-full object-cover" src="{{ $image }}" alt="{{ $title }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
    </div>
    
    <div class="p-4 flex flex-col flex-grow">
        <div class="font-bold text-lg mb-2 truncate text-gray-900 dark:text-white" title="{{ $title }}">{{ $title }}</div>
        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-3 flex-grow">
            {{ $description }}
        </p>
        <div class="mt-auto pt-2">
            <a href="{{ route('anime.guest.show', $animeId) }}" 
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1.5 px-3 rounded w-full text-center transition duration-150 ease-in-out">
                View Details
            </a>
        </div>
    </div>
</div>