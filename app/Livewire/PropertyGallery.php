<?php

namespace App\Livewire;

use Livewire\Component;

class PropertyGallery extends Component
{
    public array $images = [];
    public int $currentIndex = 0;

    public function mount(array $images): void
    {
        $this->images = $images;
    }

    public function previous(): void
    {
        $this->currentIndex = $this->currentIndex === 0 
            ? count($this->images) - 1 
            : $this->currentIndex - 1;
    }

    public function next(): void
    {
        $this->currentIndex = $this->currentIndex === count($this->images) - 1 
            ? 0 
            : $this->currentIndex + 1;
    }

    public function goTo(int $index): void
    {
        $this->currentIndex = $index;
    }

    public function render()
    {
        return view('livewire.property-gallery');
    }
}