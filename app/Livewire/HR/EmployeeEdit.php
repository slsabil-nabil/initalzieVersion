<?php

namespace App\Livewire\HR;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Livewire\Attributes\Layout;

#[Layout('layouts.agency')]
class EmployeeEdit extends Component
{
    public User $employee;
    public $name, $email, $department_id, $position_id;
    public $departments = [], $positions = [];

    public function mount($id)
    {
        $this->employee = User::findOrFail($id);

        if ($this->employee->agency_id !== Auth::user()->agency_id) {
            abort(403);
        }

        $this->departments = Department::pluck('name', 'id')->toArray();
        $this->positions = Position::pluck('name', 'id')->toArray();

        $this->name = $this->employee->name;
        $this->email = $this->employee->email;
        $this->department_id = $this->employee->department_id;
        $this->position_id = $this->employee->position_id;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->employee->id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
        ]);

        $this->employee->update([
            'name' => $this->name,
            'email' => $this->email,
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
        ]);

        session()->flash('success', 'تم تحديث بيانات الموظف بنجاح');
        return redirect()->route('hr.employees.index');
    }

    public function render()
    {
        return view('livewire.hr.employee-edit');
    }
}
