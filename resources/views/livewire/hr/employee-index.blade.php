<div class="p-6">
    {{-- ✅ الرسالة فوق الزر مباشرة بمحاذاة اليمين --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition
            class="mb-4 w-fit ml-auto bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ عنوان + زر الإضافة --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-800">قائمة الموظفين</h2>
        <a href="{{ route('hr.employees.create') }}"
            class="flex items-center gap-1 text-sm text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-1.5 rounded shadow whitespace-nowrap">
            + إضافة موظف
        </a>
    </div>


    {{-- ✅ البحث والفلاتر --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
        <input type="text" wire:model.live="search" placeholder="ابحث بالاسم أو البريد"
            class="w-full sm:w-1/3 border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-green-200">
        <select wire:model.lazy="department_id"
            class="w-full sm:w-1/4 border border-gray-300 rounded-md px-2 py-2 shadow-sm focus:outline-none focus:ring focus:ring-green-200">
            <option value="">كل الأقسام</option>
            @foreach ($departments as $id => $name)
                <option wire:key="dep-{{ $id }}" value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <select wire:model.lazy="position_id"
            class="w-full sm:w-1/4 border border-gray-300 rounded-md px-2 py-2 shadow-sm focus:outline-none focus:ring focus:ring-green-200">
            <option value="">كل الوظائف</option>
            @foreach ($positions as $id => $name)
                <option wire:key="pos-{{ $id }}" value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <p class="text-sm text-gray-600 mb-2">
        عدد الموظفين: {{ $employees->total() }}
    </p>


    {{-- ✅ جدول الموظفين --}}
    <table class="w-full text-sm text-right text-gray-700 bg-white border border-gray-200 rounded-xl shadow">
        <thead class="text-xs text-gray-700 bg-gray-100 border-b">
            <tr>
                <th class="px-4 py-3">رقم الموظف</th>
                <th class="px-4 py-3">الاسم</th>
                <th class="px-4 py-3">البريد الإلكتروني</th>
                <th class="px-4 py-3">القسم</th>
                <th class="px-4 py-3">الوظيفة</th>
                <th class="px-4 py-3">تاريخ الإنشاء</th>
                <th class="px-4 py-3 text-center">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $employee->name }}</td>
                    <td class="px-4 py-3">{{ $employee->email }}</td>
                    <td class="px-4 py-3">{{ $employee->department?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $employee->position?->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $employee->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('hr.employees.edit', $employee->id) }}"
                            class="transition px-4 py-1 rounded-lg font-medium text-emerald-600 hover:text-white hover:bg-emerald-500 border border-emerald-100 hover:border-emerald-500">
                            تعديل
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        @if ($employees->isEmpty())
            <tr>
                <td colspan="7" class="text-center py-4 text-gray-500">
                    لا توجد نتائج مطابقة لبحثك.
                </td>
            </tr>
        @endif

    </table>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
