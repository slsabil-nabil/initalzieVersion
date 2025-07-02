<?php

namespace App\Livewire\Agency;

use Livewire\Component;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class Services extends Component
{
    public $services;
    public $showModal = false;
    public $editMode = false;
    public $serviceId;
    public $name;
    public $description;
    public $price;
    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|string', // لاحقاً يمكن جعله رفع صورة
    ];

    public function mount()
    {
        $this->fetchServices();
    }

    public function fetchServices()
    {
        $this->services = Service::where('agency_id', Auth::user()->agency_id)->get();
    }

    public function showAddModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function showEditModal($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->price = $service->price;
        $this->image = $service->image;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveService()
    {
        $this->validate();
        if ($this->editMode) {
            $service = Service::findOrFail($this->serviceId);
            $service->update([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'image' => $this->image,
            ]);
            session()->flash('message', 'تم تحديث الخدمة بنجاح');
        } else {
            Service::create([
                'agency_id' => Auth::user()->agency_id,
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'image' => $this->image,
            ]);
            session()->flash('message', 'تمت إضافة الخدمة بنجاح');
        }
        $this->showModal = false;
        $this->fetchServices();
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        session()->flash('message', 'تم حذف الخدمة بنجاح');
        $this->fetchServices();
    }

    public function resetForm()
    {
        $this->serviceId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = '';
    }

    public function render()
    {
        return view('livewire.agency.services')
            ->layout('layouts.agency')
            ->title('إدارة خدمات الوكالة');
    }
}
