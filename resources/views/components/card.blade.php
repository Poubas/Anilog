@props([
    'image' => null,
    'imageAlt' => '',
    'title' => '',
    'description' => '',
    'tags' => [],
])

<div {{ $attributes->merge(['class' => 'max-w-sm rounded overflow-hidden shadow-lg']) }}>
    @if($image)
        <img class="w-full h-48 object-cover" src="{{ $image }}" alt="{{ $imageAlt }}">
    @elseif($title)
        <div class="w-full h-48 flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
            <span class="text-4xl font-bold text-white">{{ strtoupper(substr($title, 0, 1)) }}</span>
        </div>
    @endif
    
    <div class="px-6 py-4">
        @if($title)
            <div class="font-bold text-xl mb-2">{{ $title }}</div>
        @endif
        
        @if($description)
            <p class="text-gray-700 dark:text-gray-300 text-base">
                {{ $description }}
            </p>
        @endif
        
        {{ $slot ?? '' }}
    </div>
    
    @if(count($tags) > 0)
        <div class="px-6 pt-4 pb-2">
            @foreach($tags as $tag)
                <span class="inline-block bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 dark:text-gray-300 mr-2 mb-2">#{{ $tag }}</span>
            @endforeach
        </div>
    @endif
</div>