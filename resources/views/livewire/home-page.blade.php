<div class="overflow-hidden">
    {{-- ============================================
         HERO SECTION
    ============================================= --}}
    @if ($property)
    <section class="relative h-[90vh] min-h-[650px] flex items-center justify-center bg-cover bg-center bg-fixed" wire:loading.class="opacity-50" wire:target="searchAvailability"
             style="background-image: url('{{ str_starts_with($property->main_image, 'http') ? $property->main_image : asset('storage/' . $property->main_image) }}');">
        
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/60"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center">
            <p class="text-accent-500 uppercase tracking-[0.3em] text-sm md:text-base mb-4 animate-fade-in">
                Location de prestige
            </p>
            <h1 class="font-serif text-5xl md:text-7xl font-bold text-white mb-6 drop-shadow-2xl">
                {{ $property->name }}
            </h1>
            <p class="text-xl md:text-2xl text-gray-100 max-w-3xl mx-auto drop-shadow-lg mb-12 font-light">
                {{ $property->short_description }}
            </p>

            {{-- Widget de recherche --}}
            <div class="max-w-5xl mx-auto bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-6 md:p-8 border border-white/20">
                <form wire:submit="searchAvailability" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div>
                        <label for="checkIn" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Arrivée</label>
                        <input type="date" id="checkIn" wire:model.live="checkIn" 
                               class="w-full rounded-lg border-gray-200 bg-gray-50 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition duration-150 py-3">
                        @error('checkIn') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="checkOut" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Départ</label>
                        <input type="date" id="checkOut" wire:model.live="checkOut" 
                               class="w-full rounded-lg border-gray-200 bg-gray-50 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition duration-150 py-3">
                        @error('checkOut') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="guests" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Voyageurs</label>
                        <select id="guests" wire:model.live="guests" 
                                class="w-full rounded-lg border-gray-200 bg-gray-50 shadow-sm focus:border-primary-500 focus:ring-primary-500 transition duration-150 py-3">
                            @for ($i = 1; $i <= $property->max_guests; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ Str::plural('voyageur', $i) }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full bg-accent-500 hover:bg-accent-600 text-white font-semibold py-3.5 px-6 rounded-lg shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl">
                            Vérifier les disponibilités
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Indicateur de scroll --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
            <svg class="w-8 h-8 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- ============================================
         SECTION POINTS FORTS
    ============================================= --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-accent-500 uppercase tracking-[0.2em] text-sm mb-3">Pourquoi nous choisir</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-primary-900">Une expérience d'exception</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $features = [
                        ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'Sécurité maximale', 'desc' => 'Accès sécurisé et confidentialité garantie'],
                        ['icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'title' => 'Service premium', 'desc' => 'Conciergerie dédiée à votre écoute'],
                        ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'title' => 'Lieu d\'exception', 'desc' => 'Propriétés soigneusement sélectionnées'],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Flexibilité', 'desc' => 'Annulation gratuite jusqu\'à 7 jours'],
                    ];
                @endphp

                @foreach ($features as $feature)
                <div class="group text-center p-8 rounded-2xl bg-primary-50 hover:bg-white hover:shadow-soft transition-all duration-300 border border-transparent hover:border-primary-100">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent-500/10 text-accent-500 mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}"></path>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-primary-900 mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================
         SECTION À PROPOS
    ============================================= --}}
    <section id="about" class="py-24 bg-primary-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <p class="text-accent-500 uppercase tracking-[0.2em] text-sm mb-3">Notre propriété</p>
                    <h2 class="font-serif text-4xl md:text-5xl font-bold text-primary-900 mb-6">
                        {{ $property->name }}
                    </h2>
                    <p class="text-gray-700 leading-relaxed mb-8 text-lg">
                        {{ $property->description ?? $property->short_description }}
                    </p>
                    
                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                            <p class="font-serif text-3xl font-bold text-primary-900">{{ $property->max_guests }}</p>
                            <p class="text-sm text-gray-600 mt-1">Voyageurs</p>
                        </div>
                        <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                            <p class="font-serif text-3xl font-bold text-primary-900">{{ $property->bedrooms }}</p>
                            <p class="text-sm text-gray-600 mt-1">Chambres</p>
                        </div>
                        <div class="text-center p-4 bg-white rounded-xl shadow-sm">
                            <p class="font-serif text-3xl font-bold text-primary-900">{{ $property->bathrooms }}</p>
                            <p class="text-sm text-gray-600 mt-1">Salles de bain</p>
                        </div>
                    </div>

                    <a href="{{ route('property.show', $property->slug) }}" 
                       class="inline-flex items-center gap-2 bg-primary-700 hover:bg-primary-900 text-white px-8 py-4 rounded-lg font-medium transition-all duration-300 shadow-soft hover:shadow-lg hover:-translate-y-1">
                        Découvrir la propriété
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
                <div class="order-1 lg:order-2 relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/5]">
                        <img src="{{ str_starts_with($property->main_image, 'http') ? $property->main_image : asset('storage/' . $property->main_image) }}" 
                             alt="{{ $property->name }}" 
                             class="object-cover w-full h-full hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-accent-500 text-white p-6 rounded-2xl shadow-xl hidden md:block">
                        <p class="font-serif text-3xl font-bold">{{ number_format($property->base_price, 0, ',', ' ') }} €</p>
                        <p class="text-sm opacity-90">à partir de / nuit</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================
         SECTION ÉQUIPEMENTS
    ============================================= --}}
    @if (!empty($property->amenities))
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-accent-500 uppercase tracking-[0.2em] text-sm mb-3">Confort & Équipements</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-primary-900">Tout pour votre bien-être</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($property->amenities as $amenity)
                <div class="flex items-center gap-4 p-6 bg-primary-50 rounded-xl hover:bg-primary-100 transition-colors duration-200 group">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                        <svg class="w-6 h-6 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-gray-800 font-medium text-lg">{{ $amenity }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============================================
         SECTION GALERIE
    ============================================= --}}
    <section class="bg-primary-50">
        <livewire:property-gallery :images="$galleryImages" />
    </section>

    {{-- ============================================
         SECTION TÉMOIGNAGES
    ============================================= --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-accent-500 uppercase tracking-[0.2em] text-sm mb-3">Témoignages</p>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-primary-900">Ce que disent nos hôtes</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $testimonials = [
                        ['name' => 'Marie L.', 'role' => 'Famille de 4', 'text' => 'Un séjour absolument magique. La villa est encore plus belle en réalité. La piscine chauffée a fait le bonheur des enfants.'],
                        ['name' => 'Thomas R.', 'role' => 'Couple', 'text' => 'Cadre idyllique, service impeccable. Nous avons passé une semaine inoubliable. Nous reviendrons sans hésiter.'],
                        ['name' => 'Sophie & Marc', 'role' => 'Groupe d\'amis', 'text' => 'Parfait pour un séjour entre amis. La cuisine est parfaitement équipée et l\'extérieur est un vrai paradis.'],
                    ];
                @endphp

                @foreach ($testimonials as $testimonial)
                <div class="bg-primary-50 p-8 rounded-2xl relative">
                    <svg class="w-10 h-10 text-accent-500/30 absolute top-6 right-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                    <div class="flex items-center gap-1 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <p class="text-gray-700 leading-relaxed mb-6 italic">"{{ $testimonial['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-primary-700 flex items-center justify-center text-white font-bold">
                            {{ substr($testimonial['name'], 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-primary-900">{{ $testimonial['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================
         SECTION LOCALISATION
    ============================================= --}}
    @if ($property->city || $property->address)
    <section class="py-24 bg-primary-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <p class="text-accent-500 uppercase tracking-[0.2em] text-sm mb-3">Emplacement</p>
                    <h2 class="font-serif text-4xl md:text-5xl font-bold mb-6">Un cadre d'exception</h2>
                    <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                        Située {{ $property->city ? 'à ' . $property->city : '' }}{{ $property->address ? ', ' . $property->address : '' }}, 
                        cette propriété vous offre un cadre privilégié pour vos vacances.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-200">{{ $property->address ?? '' }} {{ $property->city ?? '' }}</span>
                        </div>
                    </div>
                </div>
                <div class="aspect-video bg-white/10 rounded-2xl overflow-hidden">
                    @if ($property->latitude && $property->longitude)
                    <iframe 
                        src="https://www.openstreetmap.org/export/embed.html?bbox={{ $property->longitude - 0.01 }},{{ $property->latitude - 0.01 }},{{ $property->longitude + 0.01 }},{{ $property->latitude + 0.01 }}&layer=mapnik&marker={{ $property->latitude }},{{ $property->longitude }}"
                        class="w-full h-full border-0"
                        loading="lazy">
                    </iframe>
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <p>Carte non disponible</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ============================================
         CTA FINAL
    ============================================= --}}
    <section class="py-24 bg-gradient-to-br from-primary-700 to-primary-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-accent-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-500 rounded-full filter blur-3xl"></div>
        </div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-serif text-4xl md:text-5xl font-bold mb-6">Prêt à vivre l'expérience ?</h2>
            <p class="text-xl text-gray-200 mb-10 max-w-2xl mx-auto">
                Réservez dès maintenant votre séjour et laissez-vous transporter dans un univers de luxe et de sérénité.
            </p>
            <a href="{{ route('property.show', $property->slug) }}" 
               class="inline-flex items-center gap-3 bg-accent-500 hover:bg-accent-600 text-white px-10 py-5 rounded-lg font-semibold text-lg transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                Réserver mon séjour
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </section>

    @else
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
        <h2 class="font-serif text-3xl text-primary-900 mb-4">Aucune propriété disponible pour le moment.</h2>
        <p class="text-gray-600">L'administration est en cours de configuration. Revenez bientôt.</p>
    </div>
    @endif
</div>