<?php

namespace App\Livewire\Agency;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.agency')]
class Roles extends Component
{
    use WithPagination;

    protected $layout = 'layouts.agency';

    public $search = '';
    public $showAddForm = false;
    public $editingRole = null;

    public $name;
    public $display_name;
    public $description;
    public $permissions = [];

    public $showPermissionsModal = false;
    public $viewedRole;
    public $viewedPermissions = [];
    public $editablePermissions = [];
    public $canEditPermissions = false;
    public array $availablePermissions = [];

    public function mount()
    {
        $this->availablePermissions = [
            'users.view' => 'عرض المستخدمين',
            'users.create' => 'إضافة مستخدمين',
            'users.edit' => 'تعديل المستخدمين',
            'users.delete' => 'حذف المستخدمين',
            'roles.view' => 'عرض الأدوار',
            'roles.create' => 'إضافة أدوار',
            'roles.edit' => 'تعديل الأدوار',
            'roles.delete' => 'حذف الأدوار',
            'permissions.view' => 'عرض الصلاحيات',
            'permissions.manage' => 'إدارة الصلاحيات',
            'services.view' => 'عرض الخدمات',
            'services.create' => 'إضافة خدمة',
            'services.edit' => 'تعديل خدمة',
            'services.delete' => 'حذف خدمة',
        ];
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
        ];
    }

    public function addRole()
    {
        $this->validate();

        $user = Auth::user();
        $agency = $user->agency;

        Role::create([
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'agency_id' => $agency->id,
            'permissions' => $this->permissions,
        ]);

        $this->resetForm();
        $this->showAddForm = false;
        session()->flash('message', 'تم إضافة الدور بنجاح');
    }

    public function editRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $this->editingRole = $role;
        $this->name = $role->name;
        $this->display_name = $role->display_name;
        $this->description = $role->description;

        $permissions = $this->normalizePermissions($role->permissions);
        $this->permissions = $permissions;

        $this->showAddForm = true;
    }

    public function updateRole()
    {
        $this->validate();

        $this->editingRole->update([
            'name' => $this->name,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'permissions' => $this->permissions,
        ]);

        $this->resetForm();
        $this->showAddForm = false;
        session()->flash('message', 'تم تحديث الدور بنجاح');
    }

    public function deleteRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->delete();

        session()->flash('message', 'تم حذف الدور بنجاح');
    }

    public function viewPermissions($roleId)
    {
        try {
            Log::debug('بدء عرض الصلاحيات للدور: '.$roleId);

            $this->viewedRole = Role::findOrFail($roleId);
            $this->canEditPermissions = Gate::allows('roles.edit');

            $permissions = $this->normalizePermissions($this->viewedRole->permissions);

            Log::debug('الصلاحيات المستلمة:', $permissions);

            $this->viewedPermissions = $permissions;
            $this->editablePermissions = $permissions;
            $this->showPermissionsModal = true;

            Log::debug('تم تحديث الحالة بنجاح');

            $this->dispatch('permissions-loaded');

        } catch (\Exception $e) {
            Log::error('خطأ في عرض الصلاحيات: '.$e->getMessage());
            $this->addError('error', 'حدث خطأ أثناء تحميل الصلاحيات');
        }
    }

    public function savePermissions()
    {
        if (! $this->canEditPermissions || ! $this->viewedRole) {
            return;
        }

        $this->viewedRole->update([
            'permissions' => $this->editablePermissions,
        ]);

        $this->showPermissionsModal = false;
        session()->flash('message', 'تم تحديث الصلاحيات بنجاح');
    }

    public function resetForm()
    {
        $this->editingRole = null;
        $this->name = '';
        $this->display_name = '';
        $this->description = '';
        $this->permissions = [];
    }

    private function normalizePermissions($raw)
    {
        if (is_string($raw)) {
            return json_decode($raw, true) ?? [];
        } elseif (is_array($raw)) {
            return $raw;
        }

        return [];
    }

    public function render()
    {
        $user = Auth::user();
        $agency = $user->agency;

        $roles = Role::where('agency_id', $agency->id)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount('users')
            ->latest()
            ->paginate(10);

        return view('livewire.agency.roles', compact('roles'));
    }
}
