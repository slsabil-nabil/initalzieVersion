<div class="p-6 max-w-xl mx-auto bg-white rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">تعديل بيانات الموظف</h2>

    <form wire:submit.prevent="update" class="space-y-4">
        <div>
            <label class="block mb-1 font-medium">الاسم</label>
            <input type="text" wire:model.defer="name"
                   class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-green-200">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">البريد الإلكتروني</label>
            <input type="email" wire:model.defer="email"
                   class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-green-200">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
<div class="mb-4">
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
<div class="mb-4">
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

        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            حفظ التعديلات
        </button>
    </form>
</div>
