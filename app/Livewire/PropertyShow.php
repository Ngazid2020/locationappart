<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class PropertyShow extends Component
{
    public ?Property $property = null;
    public string $checkIn = '';
    public string $checkOut = '';
    public int $guests = 2;
    public float $totalPrice = 0;
    public array $galleryImages = [];

    public function mount(string $slug): void
    {
        $this->property = Property::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $this->galleryImages = $this->property->getAllImages();
        $this->guests = min(2, $this->property->max_guests);
    }

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, [
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests'  => 'required|integer|min:1|max:' . ($this->property?->max_guests ?? 10),
        ]);

        // Recalculer le prix si les deux dates sont valides
        if ($this->checkIn && $this->checkOut && $this->property) {
            try {
                $this->totalPrice = $this->property->calculateTotalPrice($this->checkIn, $this->checkOut);
            } catch (\Exception $e) {
                $this->totalPrice = 0;
            }
        }
    }

    public function requestBooking(): void
    {
        $this->validate([
            'checkIn' => 'required|date|after_or_equal:today',
            'checkOut' => 'required|date|after:checkIn',
            'guests'  => 'required|integer|min:1|max:' . $this->property->max_guests,
        ]);

        session()->flash('booking_request', [
            'property' => $this->property->name,
            'checkIn'  => $this->checkIn,
            'checkOut' => $this->checkOut,
            'guests'   => $this->guests,
            'total'    => $this->totalPrice,
        ]);

        // Redirection vers une future page de confirmation
        // $this->redirectRoute('booking.create', [...]);
    }

    public function render()
    {
        return view('livewire.property-show')->layout('components.layouts.app', [
            'title' => $this->property?->name,
        ]);
    }
}