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
        // Récupère la première propriété active pour l'affichage initial
        $this->property = Property::where('is_active', true)->first();
        if ($this->property) {
            $this->galleryImages = $this->property->getAllImages();
        }
    }

    // Validation en temps réel pour une UX réactive (Livewire 3)
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, [
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests' => 'required|integer|min:1|max:10',
        ]);
    }

    public function searchAvailability(): void
    {
        $validated = $this->validate([
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests' => 'required|integer|min:1|max:10',
        ]);

        // Simulation d'action : affichage d'un message flash (sera remplacé par une redirection vers le processus de réservation)
        session()->flash('message', "Recherche de disponibilité pour {$validated['guests']} voyageurs, du {$validated['checkIn']} au {$validated['checkOut']}.");
    }

    public function render()
    {
        // On applique directement le layout ici pour éviter de le répéter dans la vue
        return view('livewire.home-page', [
            'galleryImages' => $this->galleryImages
        ])->layout('components.layouts.app');
    }
}
