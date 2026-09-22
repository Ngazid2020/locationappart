<div>
    @if (session()->has('booking_request'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-900 p-4 rounded-r-lg shadow-sm">
                <p class="font-medium">Demande envoyée pour {{ session('booking_request.property') }}</p>
                <p class="text-sm mt-1">Du {{ session('booking_request.checkIn') }} au {{ session('booking_request.checkOut') }} — {{ session('booking_request.guests') }} voyageurs</p>
            </div>
        </div>
    @endif

    @if ($property)
        <!-- Hero avec galerie -->
        <section class="relative bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 rounded-2xl overflow-hidden">
                    <!-- Image principale grande -->
                    <div class="md:col-span-2 md:row-span-2 relative aspect-square md:aspect-auto">
                        <img src="{{ str_starts_with($property->main_image, 'http') ? $property->main_image : asset('storage/' . $property->main_image) }}" 
                             alt="{{ $property->name }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-700 cursor-pointer">
                    </div>
                    <!-- 4 images secondaires -->
                    @foreach(array_slice($galleryImages, 1, 4) as $index => $image)
                    <div class="relative aspect-square">
                        <img src="{{ str_starts_with($image, 'http') ? $image : asset('storage/' . $image) }}" 
                             alt="Vue {{ $index + 2 }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-700 cursor-pointer">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Contenu principal -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- Colonne gauche : Informations -->
                <div class="lg:col-span-2">
                    <h1 class="font-serif text-4xl md:text-5xl font-bold text-primary-900 mb-4">
                        {{ $property->name }}
                    </h1>
                    
                    <p class="text-lg text-gray-600 mb-6">{{ $property->short_description }}</p>

                    <!-- Caractéristiques -->
                    <div class="flex flex-wrap gap-6 py-6 border-y border-gray-200 mb-8">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="font-medium">{{ $property->max_guests }} voyageurs</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span class="font-medium">{{ $property->bedrooms }} chambre{{ $property->bedrooms > 1 ? 's' : '' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="font-medium">{{ $property->bathrooms }} salle{{ $property->bathrooms > 1 ? 's' : '' }} de bain</span>
                        </div>
                    </div>

                    <!-- Description longue -->
                    @if ($property->description)
                    <div class="mb-10">
                        <h2 class="font-serif text-2xl font-bold text-primary-900 mb-4">À propos de ce logement</h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $property->description }}</p>
                    </div>
                    @endif

                    <!-- Équipements -->
                    @if (!empty($property->amenities))
                    <div class="mb-10">
                        <h2 class="font-serif text-2xl font-bold text-primary-900 mb-6">Ce que propose ce logement</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($property->amenities as $amenity)
                            <div class="flex items-center gap-3 p-3 bg-primary-50 rounded-lg">
                                <svg class="w-5 h-5 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-gray-700">{{ $amenity }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Adresse -->
                    @if ($property->address || $property->city)
                    <div class="mb-10">
                        <h2 class="font-serif text-2xl font-bold text-primary-900 mb-4">Emplacement</h2>
                        <p class="text-gray-700">
                            @if ($property->address) {{ $property->address }}@endif
                            @if ($property->city) <br>{{ $property->city }}@endif
                        </p>
                    </div>
                    @endif

                    <!-- Galerie complète -->
                    <div class="bg-primary-50">
                        <livewire:property-gallery :images="$galleryImages" />
                    </div>
                </div>

                <!-- Colonne droite : Widget de réservation (sticky) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 bg-white rounded-2xl shadow-soft border border-gray-200 p-6">
                        <div class="flex items-baseline gap-2 mb-6">
                            <span class="font-serif text-3xl font-bold text-primary-900">{{ number_format($property->base_price, 0, ',', ' ') }} €</span>
                            <span class="text-gray-600">/ nuit</span>
                        </div>

                        <form wire:submit="requestBooking" class="space-y-4">
                            <div class="grid grid-cols-2 gap-2 border border-gray-300 rounded-lg overflow-hidden">
                                <div class="p-3 border-r border-gray-300">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Arrivée</label>
                                    <input type="date" wire:model.live="checkIn" class="w-full text-sm bg-transparent focus:outline-none">
                                    @error('checkIn') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="p-3">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">Départ</label>
                                    <input type="date" wire:model.live="checkOut" class="w-full text-sm bg-transparent focus:outline-none">
                                    @error('checkOut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="border border-gray-300 rounded-lg p-3">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Voyageurs</label>
                                <select wire:model.live="guests" class="w-full text-sm bg-transparent focus:outline-none">
                                    @for ($i = 1; $i <= $property->max_guests; $i++)
                                        <option value="{{ $i }}">{{ $i }} voyageur{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>

                            @if ($totalPrice > 0)
                            <div class="space-y-2 py-4 border-t border-gray-200">
                                <div class="flex justify-between text-gray-700">
                                    <span>{{ number_format($property->base_price, 0, ',', ' ') }} € x <span id="nights-count"></span> nuits</span>
                                    <span>{{ number_format($totalPrice, 0, ',', ' ') }} €</span>
                                </div>
                                <div class="flex justify-between font-bold text-lg text-primary-900 pt-2 border-t border-gray-200">
                                    <span>Total</span>
                                    <span>{{ number_format($totalPrice, 0, ',', ' ') }} €</span>
                                </div>
                            </div>
                            @endif

                            <button type="submit" 
                                    class="w-full bg-accent-500 hover:bg-accent-600 text-white font-semibold py-3.5 rounded-lg shadow-md transition-all duration-200 hover:-translate-y-0.5">
                                Réserver
                            </button>
                        </form>

                        <p class="text-center text-sm text-gray-500 mt-4">Aucun montant débité pour le moment</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>