<?php

namespace App\Livewire\Agency;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Users extends Component
{
    public $search = '';
    public $showAddForm = false;
    public $editingUser = null;

    // Form fields
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $is_active = true;
    public $user_type = 'agency_user';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->editingUser)],
            'role_id' => 'nullable|exists:roles,id',
            'is_active' => 'boolean',
            'user_type' => 'required|in:agency_user,agency_admin',
        ];

        if (!$this->editingUser) {
            $rules['password'] = 'required|string|min:6';
        }

        return $rules;
    }

    public function addUser()
    {
        $this->validate();
         $user = Auth::user();
        $agency = $user->agency;
        $currentUsersCount = $agency->users()->count();
        if ($currentUsersCount >= $agency->max_users) {
            session()->flash('error', 'لا يمكن إضافة المزيد من المستخدمين. الحد الأقصى المسموح به لهذه الوكالة هو ' . $agency->max_users . ' مستخدم.');
            return;
        }
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'user_type' => $this->user_type,
            'agency_id' => $agency->id,
            'role_id' => $this->role_id,
            'is_active' => $this->is_active,
            'email_verified_at' => now(),
        ]);
        $this->resetForm();
        $this->showAddForm = false;
        session()->flash('message', 'تم إضافة المستخدم بنجاح');
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->is_active = $user->is_active;
        $this->user_type = $user->user_type;
        $this->showAddForm = true;
    }

    public function updateUser()
    {
        $this->validate();

        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => $this->user_type,
            'role_id' => $this->role_id,
            'is_active' => $this->is_active,
        ]);

        if ($this->password) {
            $this->editingUser->update(['password' => Hash::make($this->password)]);
        }

        $this->resetForm();
        $this->showAddForm = false;
        session()->flash('message', 'تم تحديث المستخدم بنجاح');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        session()->flash('message', 'تم حذف المستخدم بنجاح');
    }

    public function toggleUserStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);
        session()->flash('message', 'تم تحديث حالة المستخدم بنجاح');
    }

    public function resetForm()
    {
        $this->editingUser = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role_id = '';
        $this->is_active = true;
        $this->user_type = 'agency_user';
    }

    public function render()
    {
        $user = Auth::user();
        $agency = $user->agency;

        $users = User::where('agency_id', $agency->id)
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with('role')
            ->latest()
            ->paginate(10);

        $roles = Role::where('agency_id', $agency->id)->get();

        return view('livewire.agency.users', compact('users', 'roles'))
            ->layout('layouts.agency');
    }
}
