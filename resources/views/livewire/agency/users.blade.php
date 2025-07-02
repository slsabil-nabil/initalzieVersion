<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">إدارة المستخدمين</h1>
                <p class="text-gray-600">إدارة مستخدمي الوكالة وإضافة مستخدمين جدد</p>
            </div>
            <button wire:click="$set('showAddForm', true)" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg transition duration-200">
                إضافة مستخدم جديد
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex gap-4">
            <div class="flex-1">
                <input wire:model.live="search" 
                       type="text" 
                       placeholder="البحث في المستخدمين..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    @if($showAddForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center min-h-screen bg-gradient-to-br from-emerald-100/70 to-cyan-100/70">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 flex flex-col items-center justify-center relative">
            <div class="flex justify-between items-center mb-4 w-full">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $editingUser ? 'تعديل المستخدم' : 'إضافة مستخدم جديد' }}
                </h2>
                <button wire:click="$set('showAddForm', false)" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form wire:submit.prevent="{{ $editingUser ? 'updateUser' : 'addUser' }}" class="w-full">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                        <input wire:model="name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                        <input wire:model="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $editingUser ? 'كلمة المرور الجديدة (اختياري)' : 'كلمة المرور' }}
                        </label>
                        <input wire:model="password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">نوع المستخدم</label>
                        <select wire:model="user_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="agency_user">مستخدم عادي</option>
                            <option value="agency_admin">مدير وكالة</option>
                        </select>
                        @error('user_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">الدور</label>
                        <select wire:model="role_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                            <option value="">بدون دور</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input wire:model="is_active" type="checkbox" id="is_active" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <label for="is_active" class="mr-2 text-sm text-gray-700">نشط</label>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-4 rounded-lg transition duration-200">
                        {{ $editingUser ? 'تحديث' : 'إضافة' }}
                    </button>
                    <button type="button" wire:click="$set('showAddForm', false)" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg transition duration-200">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            المستخدم
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            البريد الإلكتروني
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            نوع المستخدم
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الدور
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاريخ الإضافة
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-emerald-600 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->user_type === 'agency_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $user->user_type === 'agency_admin' ? 'مدير وكالة' : 'مستخدم عادي' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $user->role->name }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">بدون دور</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleUserStatus({{ $user->id }})" 
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-row items-center justify-center gap-8">
                                    <button wire:click="editUser({{ $user->id }})"
                                        class="transition px-4 py-1 rounded-lg font-medium text-emerald-600 hover:text-white hover:bg-emerald-500 border border-emerald-100 hover:border-emerald-500">
                                        تعديل
                                    </button>
                                    <button wire:click="deleteUser({{ $user->id }})"
                                        onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')"
                                        class="transition px-4 py-1 rounded-lg font-medium text-red-600 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500">
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                لا يوجد مستخدمين مسجلين حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Success Message -->
    @if(session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg text-center">
            {{ session('error') }}
        </div>
    @endif
</div> 