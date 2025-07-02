<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">إدارة الأدوار</h1>
                <p class="text-gray-600">إنشاء وإدارة أدوار المستخدمين في الوكالة</p>
            </div>
            <button wire:click="$set('showAddForm', true)"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg transition duration-200">
                إضافة دور جديد
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex gap-4">
            <div class="flex-1">
                <input wire:model.live="search" type="text" placeholder="البحث في الأدوار..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Add/Edit Role Modal -->
    @if ($showAddForm)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center min-h-screen bg-gradient-to-br from-emerald-100/70 to-cyan-100/70">
            <div
                class="bg-white rounded-lg p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto flex flex-col items-center justify-center relative">
                <div class="flex justify-between items-center mb-4 w-full">
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $editingRole ? 'تعديل الدور' : 'إضافة دور جديد' }}
                    </h2>
                    <button wire:click="$set('showAddForm', false)" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form wire:submit.prevent="{{ $editingRole ? 'updateRole' : 'addRole' }}" class="w-full">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">اسم الدور</label>
                            <input wire:model="name" type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">اسم العرض</label>
                            <input wire:model="display_name" type="text" placeholder="مثال: مدير الخدمات"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            @error('display_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الوصف</label>
                            <textarea wire:model="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"></textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">الصلاحيات</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($availablePermissions as $permission => $label)
                                    <div class="flex items-center">
                                        <input wire:model="permissions" type="checkbox" value="{{ $permission }}"
                                            id="perm_{{ $permission }}"
                                            class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                                        <label for="perm_{{ $permission }}"
                                            class="mr-2 text-sm text-gray-700">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-4 rounded-lg transition duration-200">
                            {{ $editingRole ? 'تحديث' : 'إضافة' }}
                        </button>
                        <button type="button" wire:click="$set('showAddForm', false)"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg transition duration-200">
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Roles Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <!-- اسم الدور -->
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            اسم الدور
                        </th>

                        <!-- الوصف -->
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الوصف
                        </th>

                        <!-- الصلاحيات -->
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الصلاحيات
                        </th>

                        <!-- عدد المستخدمين -->
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            عدد المستخدمين
                        </th>

                        <!-- تاريخ الإنشاء -->
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاريخ الإنشاء
                        </th>

                        <!-- الإجراءات -->
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>

                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($roles as $role)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $role->display_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $role->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    {{ $role->description ?: 'لا يوجد وصف' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="viewPermissions({{ $role->id }})" wire:loading.attr="disabled"
                                    class="transition px-4 py-1 rounded-lg font-medium text-blue-700 hover:text-white hover:bg-blue-500 border border-blue-100 hover:border-blue-500 min-w-[72px] relative text-center">

                                    <!-- Spinner عند التحميل -->
                                    <span wire:loading wire:target="viewPermissions({{ $role->id }})"
                                        class="absolute right-2 top-1/2 -translate-y-1/2">
                                        <svg class="animate-spin h-4 w-4 text-blue-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2
                     5.291A7.962 7.962 0 014 12H0c0
                     3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </span>

                                    <!-- النص "عرض" -->
                                    <span wire:loading.remove>عرض</span>
                                </button>


                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $role->users_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $role->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-row items-center justify-center gap-8">
                                    <button wire:click="editRole({{ $role->id }})"
                                        class="transition px-4 py-1 rounded-lg font-medium text-emerald-600 hover:text-white hover:bg-emerald-500 border border-emerald-100 hover:border-emerald-500">
                                        تعديل
                                    </button>
                                    <button wire:click="deleteRole({{ $role->id }})"
                                        onclick="return confirm('هل أنت متأكد من حذف هذا الدور؟')"
                                        class="transition px-4 py-1 rounded-lg font-medium text-red-600 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500">
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                لا يوجد أدوار مسجلة حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($roles->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $roles->links() }}
            </div>
        @endif
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    <!-- Debug Info -->
    <div class="fixed bottom-0 left-0 bg-yellow-100 p-2 z-[99999] text-xs">
        Debug:
        showModal: {{ $showPermissionsModal ? 'true' : 'false' }} |
        Role: {{ $viewedRole?->id ?? 'null' }} |
        Perms: {{ count($viewedPermissions ?? []) }}
    </div>

    <!-- Permissions Modal -->
    @if ($showPermissionsModal)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm"
            wire:key="permissions-modal">
            <!-- الخلفية -->
            <div class="absolute inset-0" wire:click="$set('showPermissionsModal', false)"></div>

            <!-- محتوى المودال -->
            <div class="relative mx-4 w-full max-w-3xl bg-white rounded-xl shadow-xl p-6 overflow-y-auto max-h-[90vh]">
                <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">
                    صلاحيات دور: {{ $viewedRole?->display_name ?? '' }}
                </h2>

                @if ($viewedPermissions && count($viewedPermissions) > 0)
                    @if ($canEditPermissions)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($availablePermissions as $perm => $label)
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="editablePermissions"
                                        value="{{ $perm }}"
                                        class="h-4 w-4 text-emerald-600 border-gray-300 rounded">
                                    <label class="mr-2 text-sm text-gray-700">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-wrap justify-center gap-3">
                            @foreach ($viewedPermissions as $perm)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-sm font-medium shadow-sm">
                                    <svg class="w-4 h-4 text-emerald-600 ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $availablePermissions[$perm] ?? $perm }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-500 text-center">لا توجد صلاحيات لهذا الدور</p>
                @endif


                <div class="mt-6 flex justify-end gap-3">
                    @if ($canEditPermissions)
                        <button wire:click="savePermissions"
                            class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                            حفظ التعديلات
                        </button>
                    @endif
                    <button wire:click="$set('showPermissionsModal', false)"
                        class="px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
                        إغلاق
                    </button>

                </div>
            </div>
        </div>
    @endif


</div>
