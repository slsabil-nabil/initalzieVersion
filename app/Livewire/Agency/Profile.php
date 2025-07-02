<?php

namespace App\Livewire\Agency;

use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        $agency = auth()->user()->agency;
        return view('livewire.agency.profile', compact('agency'))
            ->layout('layouts.agency');
    }
} 