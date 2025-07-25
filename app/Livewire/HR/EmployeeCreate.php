<?php

namespace App\Livewire\HR;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.agency')]
class EmployeeCreate extends Component
{
    public $name, $email, $password, $password_confirmation;
    public $department_id, $position_id;
    public $departments = [], $positions = [];

    public function mount()
    {
        $this->departments = Department::pluck('name', 'id')->toArray();
        $this->positions = Position::pluck('name', 'id')->toArray();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
        ];
    }

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'agency_id' => Auth::user()->agency_id,
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
        ]);

        session()->flash('success', 'تمت إضافة الموظف بنجاح');
        return redirect()->route('hr.employees.index');
    }

    public function render()
    {
        return view('livewire.hr.employee-create');
    }
}
