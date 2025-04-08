<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Explorar Anime</h1>

        <form method="GET" action="{{ route('anime.browse') }}" class="mb-8">
            <div class="flex flex-col md:flex-row gap-2 mb-4">
                <input 
                    type="text" 
                    name="query" 
                    value="{{ $query }}" 
                    placeholder="Pesquisar anime..." 
                    class="border border-gray-300 dark:border-gray-700 rounded-md p-2 w-full dark:bg-gray-800 dark:text-white"
                >
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out md:w-auto w-full"
                >
                    Pesquisar
                </button>
            </div>
            
            <!-- Opções de Classificação e Filtro -->
            <div x-data="{ isOpen: false }" class="mt-4">
                <button 
                    @click.prevent="isOpen = !isOpen" 
                    type="button"
                    class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-left text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus-visible:ring focus-visible:ring-gray-500 focus-visible:ring-opacity-75"
                >
                    <span>Opções de Classificação e Filtro</span>
                    <svg 
                        class="w-5 h-5 transform transition-transform duration-150" 
                        :class="{'rotate-180': isOpen}"
                        fill="currentColor" 
                        viewBox="0 0 20 20"
                    >
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div 
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="mt-2 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg"
                >
                    <!-- Opções de Classificação -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ordenar por:</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($sortOptions as $value => $label)
                                <label 
                                    class="px-3 py-1 text-sm rounded-full cursor-pointer {{ $sort === $value 
                                        ? 'bg-blue-600 text-white' 
                                        : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition duration-150 ease-in-out"
                                >
                                    <input 
                                        type="radio" 
                                        name="sort" 
                                        value="{{ $value }}" 
                                        {{ $sort === $value ? 'checked' : '' }}
                                        class="hidden"
                                    >
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Direção da Ordenação -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ordem:</label>
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <label 
                                class="px-4 py-2 text-sm font-medium cursor-pointer {{ $direction === 'desc' 
                                    ? 'bg-blue-600 text-white' 
                                    : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-l-lg border-r border-gray-300 dark:border-gray-600"
                            >
                                <input 
                                    type="radio" 
                                    name="direction" 
                                    value="desc" 
                                    {{ $direction === 'desc' ? 'checked' : '' }}
                                    class="hidden"
                                >
                                Decrescente
                            </label>
                            
                            <label 
                                class="px-4 py-2 text-sm font-medium cursor-pointer {{ $direction === 'asc' 
                                    ? 'bg-blue-600 text-white' 
                                    : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} rounded-r-lg"
                            >
                                <input 
                                    type="radio" 
                                    name="direction" 
                                    value="asc" 
                                    {{ $direction === 'asc' ? 'checked' : '' }}
                                    class="hidden"
                                >
                                Crescente
                            </label>
                        </div>
                    </div>
                    
                    <!-- Filtro de Gênero -->
                    <div>
                        <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Filtrar por Gênero</label>
                        
                        <!-- Seção Incluir Gêneros -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Incluir Gêneros:</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($genres as $genre)
                                    <label 
                                        class="px-3 py-1 text-xs rounded-full cursor-pointer {{ in_array($genre['id'], $selectedGenres) 
                                            ? 'bg-blue-600 text-white' 
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition duration-150 ease-in-out"
                                    >
                                        <input 
                                            type="checkbox" 
                                            name="genres[]" 
                                            value="{{ $genre['id'] }}" 
                                            {{ in_array($genre['id'], $selectedGenres) ? 'checked' : '' }}
                                            class="hidden"
                                        >
                                        {{ $genre['name'] }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Seção Excluir Gêneros -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excluir Gêneros:</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($genres as $genre)
                                    <label 
                                        class="px-3 py-1 text-xs rounded-full cursor-pointer {{ in_array($genre['id'], $excludedGenres) 
                                            ? 'bg-red-600 text-white' 
                                            : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }} transition duration-150 ease-in-out"
                                    >
                                        <input 
                                            type="checkbox" 
                                            name="excluded_genres[]" 
                                            value="{{ $genre['id'] }}" 
                                            {{ in_array($genre['id'], $excludedGenres) ? 'checked' : '' }}
                                            class="hidden"
                                        >
                                        {{ $genre['name'] }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Botão Aplicar Filtros -->
                        <div class="mt-6 flex justify-end">
                            <button 
                                type="submit" 
                                class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-150 ease-in-out"
                            >
                                Aplicar Filtros
                            </button>
                            
                            @if(!empty($selectedGenres) || !empty($excludedGenres) || $sort !== 'score' || $direction !== 'desc')
                                <a 
                                    href="{{ route('anime.browse') }}{{ !empty($query) ? '?query=' . $query : '' }}" 
                                    class="ml-2 px-4 py-2 text-sm bg-gray-600 hover:bg-gray-700 text-white rounded-md transition duration-150 ease-in-out"
                                >
                                    Limpar Todos os Filtros
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>

        @if(count($animes) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($animes as $anime)
                    <x-anime-card 
                        :title="$anime['title']" 
                        :description="$anime['synopsis'] ?? ''" 
                        :image="$anime['images']['jpg']['image_url'] ?? ''" 
                        :animeId="$anime['mal_id']"
                    />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $paginator->links() }}
            </div>
        @else
            <div class="text-center p-10 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-lg">
                <p class="text-gray-500 dark:text-gray-400">Nenhum anime encontrado para sua pesquisa.</p>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tente termos ou filtros diferentes.</p>
            </div>
        @endif
    </div>

    <script>
        // Adiciona classe ativa nos botões quando são clicados
        document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', function() {
                if (this.type === 'radio') {
                    // Para botões de rádio (sort e direction)
                    const name = this.name;
                    document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                        const parent = radio.parentElement;
                        if (radio.checked) {
                            parent.classList.add('bg-blue-600', 'text-white');
                            parent.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        } else {
                            parent.classList.remove('bg-blue-600', 'text-white');
                            parent.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        }
                    });
                } else {
                    // Para checkboxes (gêneros)
                    const parent = this.parentElement;
                    if (this.checked) {
                        if (this.name === 'genres[]') {
                            parent.classList.add('bg-blue-600', 'text-white');
                            parent.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        } else {
                            parent.classList.add('bg-red-600', 'text-white');
                            parent.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                        }
                    } else {
                        if (this.name === 'genres[]') {
                            parent.classList.remove('bg-blue-600', 'text-white');
                        } else {
                            parent.classList.remove('bg-red-600', 'text-white');
                        }
                        parent.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200');
                    }
                }
            });
        });
    </script>
</x-app-layout>