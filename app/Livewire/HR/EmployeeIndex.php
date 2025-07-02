<?php

namespace App\Livewire\HR;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;



use Livewire\Attributes\Layout;

#[Layout('layouts.agency')]
class EmployeeIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $department_id = '';
    public $position_id = '';

    public $departments = [];
    public $positions = [];
    protected $updatesQueryString = ['search', 'department_id', 'position_id'];

    protected $queryString = ['search'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->departments = Department::pluck('name', 'id')->toArray();
        $this->positions = Position::pluck('name', 'id')->toArray();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartmentId()
    {
        $this->resetPage();
    }

    public function updatingPositionId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $employees = User::with(['department', 'position'])
            ->where('agency_id', Auth::user()->agency_id)
            ->when($this->search, function ($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', $searchTerm)
                        ->orWhere('email', 'LIKE', $searchTerm);
                });
            })
            ->when($this->department_id, fn($q) => $q->where('department_id', $this->department_id))
            ->when($this->position_id, fn($q) => $q->where('position_id', $this->position_id))
            ->latest()
            ->paginate(10);

        return view('livewire.hr.employee-index', compact('employees'));
    }
}
