<?php

namespace App\Livewire\Agency;

use App\Models\AgencySetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.agency')]
class AgencySetup extends Component
{
    use WithFileUploads;

    public $logo;
    public $agency_name;
    public $main_branch_name;
    public $currency;
    public $phone;
    public $landline;
    public $email;

    public $alreadyInitialized = false;

    public function mount()
    {
        $agency = Auth::user()->agency;

        if ($agency->setting) {
            $this->alreadyInitialized = true;

            $this->agency_name      = $agency->setting->agency_name;
            $this->main_branch_name = $agency->setting->main_branch_name;
            $this->currency         = $agency->setting->currency;
            $this->phone            = $agency->setting->phone;
            $this->landline         = $agency->setting->landline;
            $this->email            = $agency->setting->email;
        }
    }

    public function save()
    {
        $this->validate([
            'logo' => 'required|image|max:2048',
            'agency_name' => 'required|string|max:255',
            'main_branch_name' => 'required|string|max:255',
            'currency' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'landline' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $path = $this->logo->store('logos', 'public');

        Auth::user()->agency->setting()->create([
            'logo' => $path,
            'agency_name' => $this->agency_name,
            'main_branch_name' => $this->main_branch_name,
            'currency' => $this->currency,
            'phone' => $this->phone,
            'landline' => $this->landline,
            'email' => $this->email,
        ]);

        return redirect()->route('agency.show');
    }

    public function updateContactInfo()
    {
        $this->validate([
            'phone' => 'nullable|string|max:20',
            'landline' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Auth::user()->agency->setting->update([
            'phone' => $this->phone,
            'landline' => $this->landline,
            'email' => $this->email,
        ]);

        session()->flash('message', 'تم تحديث معلومات الاتصال بنجاح.');
    }

    public function render()
    {
        return view('livewire.agency.agency-setup');
    }
}
