<?php

namespace App\Livewire\Agency;

use Livewire\Component;

class Permissions extends Component
{
    public function render()
    {
        return view('livewire.agency.permissions')
            ->layout('layouts.agency');
    }
} 