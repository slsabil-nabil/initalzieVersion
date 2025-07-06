<?php

namespace App\Livewire\Agency;

use Livewire\Component;
use App\Models\AgencySetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use App\Models\Branch;

#[Layout('layouts.agency')]
class AgencyShow extends Component
{
    public $phone;
    public $landline;
    public $email;

    public $setting;
    public $branches;
    public $branchName, $branchPhone, $branchEmail, $branchAddress;
    public function mount()
    {
        $agency = Auth::user()->agency;
        $this->setting = Auth::user()->agency->setting;
        $this->phone = $this->setting->phone;
        $this->landline = $this->setting->landline;
        $this->email = $this->setting->email;
        $this->branches = $agency->branches;
    }

    public function updatedPhone()
    {
        $this->setting->update(['phone' => $this->phone]);
        session()->flash('success', 'تم تحديث رقم الهاتف');
    }

    public function updatedLandline()
    {
        $this->setting->update(['landline' => $this->landline]);
        session()->flash('success', 'تم تحديث الهاتف الثابت');
    }

    public function updatedEmail()
    {
        $this->setting->update(['email' => $this->email]);
        session()->flash('success', 'تم تحديث البريد الإلكتروني');
    }
    public function addBranch()
    {
        $this->validate([
            'branchName' => 'required|string|max:255',
            'branchPhone' => 'nullable|string',
            'branchEmail' => 'nullable|email',
            'branchAddress' => 'nullable|string',
        ]);

        auth()->user()->agency->branches()->create([
            'name' => $this->branchName,
            'phone' => $this->branchPhone,
            'email' => $this->branchEmail,
            'address' => $this->branchAddress,
        ]);

        $this->branches = auth()->user()->agency->branches;


        $this->reset(['branchName', 'branchPhone', 'branchEmail', 'branchAddress']);
        session()->flash('success', 'تمت إضافة الفرع بنجاح ✅');
    }
    public function render()
    {
        return view('livewire.agency.agency-show', [
            'branches' => auth()->user()->agency->branches,
        ]);
    }
}
