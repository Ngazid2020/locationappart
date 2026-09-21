<div class="py-20 bg-primary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-primary-900 text-center mb-12">
            Galerie Photos
        </h2>

        @if(count($images) > 0)
        <div class="relative">
            <!-- Image principale -->
            <div class="relative aspect-[16/10] md:aspect-[21/9] rounded-2xl overflow-hidden shadow-soft bg-gray-200">
                <img
                    src="{{ asset('storage/' . $images[$currentIndex]) }}"
                    alt="Vue {{ $currentIndex + 1 }}"
                    class="w-full h-full object-cover transition-opacity duration-500"
                    wire:key="image-{{ $currentIndex }}">

                <!-- Overlay dégradé -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
            </div>

            <!-- Flèches de navigation (affichées seulement si plus d'une image) -->
            @if(count($images) > 1)
            <button
                wire:click="previous"
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-primary-900 p-3 rounded-full shadow-lg transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary-500"
                aria-label="Image précédente">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button
                wire:click="next"
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-primary-900 p-3 rounded-full shadow-lg transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-primary-500"
                aria-label="Image suivante">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            @endif

            <!-- Indicateurs (thumbnails) -->
            @if(count($images) > 1)
            <div class="flex justify-center gap-3 mt-6 overflow-x-auto pb-2">
                @foreach($images as $index => $image)
                <button
                    wire:click="goTo({{ $index }})"
                    class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 rounded-lg overflow-hidden border-2 transition-all duration-200 {{ $index === $currentIndex ? 'border-primary-500 ring-2 ring-primary-200' : 'border-transparent hover:border-primary-300' }}">
                    <img
                        src="{{ asset('storage/' . $image) }}"
                        alt="Miniature {{ $index + 1 }}"
                        class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-soft">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-gray-500 text-lg">Aucune photo disponible pour le moment</p>
        </div>
        @endif
    </div>
</div>