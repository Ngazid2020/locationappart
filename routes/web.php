<?php

use App\Livewire\HomePage;
use App\Livewire\PropertyShow;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/propriete/{slug}', PropertyShow::class)->name('property.show');
