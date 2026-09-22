<div>
    {{-- Message de confirmation après soumission du formulaire --}}
    @if (session()->has('message'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
        <div class="bg-primary-100 border-l-4 border-primary-500 text-primary-900 p-4 rounded-r-lg shadow-sm" role="alert">
            <p class="font-medium">{{ session('message') }}</p>
        </div>
    </div>
    @endif

    @if ($property)
    <!-- Hero Section avec Image de fond -->
    <section class="relative h-[85vh] min-h-[600px] flex items-center justify-center bg-cover bg-center"
        style="background-image: url('{{ $property->main_image ? asset('storage/' . $property->main_image) : 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?q=80&w=2070&auto=format&fit=crop' }}');">

        <!-- Overlay sombre pour garantir la lisibilité du texte -->
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center">
            <h1 class="font-serif text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">
                <a href="{{ route('property.show', $property->slug) }}" class="block group">
                    <h1 class="font-serif text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg group-hover:text-accent-500 transition-colors">
                        {{ $property->name }}
                    </h1>
                </a>
            </h1>
            <p class="text-xl text-gray-100 max-w-2xl mx-auto drop-shadow-md mb-10">
                {{ $property->short_description }}
                <a href="{{ route('property.show', $property->slug) }}"
                    class="inline-block bg-primary-700 hover:bg-primary-900 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-soft">
                    Découvrir la propriété →
                </a>
            </p>

            <!-- Widget de recherche de disponibilité -->
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-soft p-6 md:p-8">
                <form wire:submit="searchAvailability" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    <!-- Date d'arrivée -->
                    <div>
                        <label for="checkIn" class="block text-sm font-medium text-gray-700 mb-1">Arrivée</label>
                        <input type="date" id="checkIn" wire:model.live="checkIn"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition duration-150">
                        @error('checkIn') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date de départ -->
                    <div>
                        <label for="checkOut" class="block text-sm font-medium text-gray-700 mb-1">Départ</label>
                        <input type="date" id="checkOut" wire:model.live="checkOut"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition duration-150">
                        @error('checkOut') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Voyageurs -->
                    <div>
                        <label for="guests" class="block text-sm font-medium text-gray-700 mb-1">Voyageurs</label>
                        <select id="guests" wire:model.live="guests"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition duration-150">
                            @foreach(range(1, 10) as $count)
                            <option value="{{ $count }}">{{ $count }} {{ Str::plural('voyageur', $count) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bouton d'action -->
                    <div>
                        <button type="submit"
                            class="w-full bg-accent-500 hover:bg-accent-600 text-white font-semibold py-3.5 px-6 rounded-lg shadow-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                            Vérifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Section Description (Aperçu) -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-primary-900 mb-6">Une expérience unique</h2>
                    <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                        {{ $property->short_description }}
                    </p>
                    <div class="flex flex-wrap gap-6 text-primary-700 font-medium">
                        <span class="flex items-center bg-primary-50 px-4 py-2 rounded-full">
                            <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Piscine privée
                        </span>
                        <span class="flex items-center bg-primary-50 px-4 py-2 rounded-full">
                            <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Wi-Fi haut débit
                        </span>
                    </div>
                </div>
                <div class="relative rounded-2xl overflow-hidden shadow-soft aspect-video">
                    <img src="{{ $property->main_image ? asset('storage/' . $property->main_image) : 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?q=80&w=2070&auto=format&fit=crop' }}"
                        alt="{{ $property->name }}"
                        class="object-cover w-full h-full hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>
    <!-- Galerie Photos -->
    <section class="bg-primary-50">
        <livewire:property-gallery :images="$galleryImages" />
    </section>
    @else
    <!-- État vide si aucune propriété n'est configurée -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
        <h2 class="font-serif text-3xl text-primary-900 mb-4">Aucune propriété disponible pour le moment.</h2>
        <p class="text-gray-600">L'administration est en cours de configuration. Revenez bientôt.</p>
    </div>
    @endif
</div>