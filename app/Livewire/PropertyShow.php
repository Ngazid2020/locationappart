<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;
use Carbon\Carbon;

class PropertyShow extends Component
{
    public ?Property $property = null;
    public string $checkIn = '';
    public string $checkOut = '';
    public int $guests = 2;
    public float $totalPrice = 0;
    public int $nights = 0; // <-- AJOUT : Propriété pour le nombre de nuits
    public array $galleryImages = [];
    public bool $isAvailable = true;
    public string $availabilityMessage = '';

    public function mount(string $slug): void
    {
        $this->property = Property::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $this->galleryImages = $this->property->getAllImages();
        $this->guests = min(2, $this->property->max_guests);

        if (request()->has('checkIn')) $this->checkIn = request()->query('checkIn');
        if (request()->has('checkOut')) $this->checkOut = request()->query('checkOut');
        if (request()->has('guests')) $this->guests = (int) request()->query('guests');

        // Calculer le prix et les nuits si les dates sont présentes
        if ($this->checkIn && $this->checkOut) {
            $this->calculatePricing();
        }
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, [
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests'  => 'required|integer|min:1|max:' . ($this->property?->max_guests ?? 10),
        ]);

        if ($this->checkIn && $this->checkOut && $this->property) {
            $this->calculatePricing();
        }
    }

    /**
     * Méthode centralisée pour calculer les nuits, le prix et la disponibilité
     */
    private function calculatePricing(): void
    {
        try {
            $start = Carbon::parse($this->checkIn);
            $end = Carbon::parse($this->checkOut);
            
            // Calcul du nombre de nuits
            $this->nights = $start->diffInDays($end);

            // Calcul du prix
            $this->totalPrice = $this->property->calculateTotalPrice($this->checkIn, $this->checkOut);
            
            // Vérification de la disponibilité
            $this->isAvailable = $this->property->isAvailable($this->checkIn, $this->checkOut);
            $this->availabilityMessage = $this->isAvailable ? '' : 'Désolé, cette période n\'est plus disponible.';
            
        } catch (\Exception $e) {
            $this->totalPrice = 0;
            $this->nights = 0;
        }
    }

    public function requestBooking(): void
    {
        $this->validate([
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests'  => 'required|integer|min:1|max:' . $this->property->max_guests,
        ]);

        if (!$this->property->isAvailable($this->checkIn, $this->checkOut)) {
            $this->addError('checkIn', 'Cette période n\'est malheureusement plus disponible.');
            return;
        }

        $booking = $this->property->bookings()->create([
            'guest_name'  => auth()->user()?->name ?? 'Client',
            'guest_email' => auth()->user()?->email ?? 'client@email.com',
            'check_in'    => $this->checkIn,
            'check_out'   => $this->checkOut,
            'guests'      => $this->guests,
            'total_price' => $this->totalPrice,
            'status'      => 'pending',
        ]);

        session()->flash('booking_request', [
            'property' => $this->property->name,
            'checkIn'  => $this->checkIn,
            'checkOut' => $this->checkOut,
            'guests'   => $this->guests,
            'total'    => $this->totalPrice,
            'id'       => $booking->id,
        ]);
    }

    public function render()
    {
        return view('livewire.property-show')->layout('components.layouts.app', [
            'title' => $this->property?->name,
        ]);
    }
}