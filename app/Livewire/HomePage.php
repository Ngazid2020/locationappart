<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class HomePage extends Component
{
    public $property;
    public string $checkIn = '';
    public string $checkOut = '';
    public int $guests = 2;
    public array $galleryImages = [];

    public function mount(): void
    {
        $this->property = Property::where('is_active', true)->first();
        if ($this->property) {
            $this->galleryImages = $this->property->getAllImages();
            $this->guests = min(2, $this->property->max_guests);
        }
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, [
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests'  => 'required|integer|min:1|max:' . ($this->property?->max_guests ?? 10),
        ]);
    }

    public function searchAvailability(): void
    {
        $validated = $this->validate([
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests'  => 'required|integer|min:1|max:' . ($this->property->max_guests ?? 10),
        ]);

        // Redirection vers la page de détail avec les dates en paramètres
        $this->redirectRoute('property.show', [
            'slug'    => $this->property->slug,
            'checkIn' => $validated['checkIn'],
            'checkOut' => $validated['checkOut'],
            'guests'  => $validated['guests'],
        ]);
    }

    public function render()
    {
        return view('livewire.home-page', [
            'galleryImages' => $this->galleryImages
        ])->layout('components.layouts.app', [
            'title' => $this->property?->name ?? 'Accueil'
        ]);
    }
}