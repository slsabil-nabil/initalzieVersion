<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">إضافة موظف جديد</h2>
        <a href="{{ route('hr.employees.index') }}"
           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-xl shadow transition-all duration-200 text-sm">
            ← العودة للقائمة
        </a>
    </div>

    <div class="max-w-xl mx-auto bg-white border border-gray-200 rounded-xl shadow p-6">
        <form wire:submit.prevent="save" class="space-y-4">
            {{-- الاسم --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                <input type="text" wire:model.defer="name" id="name"
                       class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- البريد الإلكتروني --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                <input type="email" wire:model.defer="email" id="email"
                       class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- كلمة المرور --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
                <input type="password" wire:model.defer="password" id="password"
                       class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- تأكيد كلمة المرور --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور</label>
                <input type="password" wire:model.defer="password_confirmation" id="password_confirmation"
                       class="w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            {{-- القسم --}}
            <div>
                <label for="department_id" class="block text-sm font-medium text-gray-700">القسم</label>
                <select wire:model="department_id" id="department_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="">اختر القسم</option>
                    @foreach($departments as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('department_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- الوظيفة --}}
            <div>
                <label for="position_id" class="block text-sm font-medium text-gray-700">الوظيفة</label>
                <select wire:model="position_id" id="position_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="">اختر الوظيفة</option>
                    @foreach($positions as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                @error('position_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- زر الحفظ --}}
            <div>
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl shadow transition">
                    حفظ الموظف
                </button>
            </div>
        </form>
    </div>
</div>
