<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6 text-emerald-700">إدارة خدمات الوكالة</h2>

    @if(session('message'))
        <div class="bg-emerald-100 text-emerald-700 rounded-lg p-3 text-center mb-4">{{ session('message') }}</div>
    @endif

    <div class="mb-4 flex justify-end">
        <button wire:click="showAddModal" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold shadow transition">إضافة خدمة جديدة</button>
    </div>

    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-emerald-50 text-emerald-700">
                    <th class="py-3 px-4 text-right">#</th>
                    <th class="py-3 px-4 text-right">اسم الخدمة</th>
                    <th class="py-3 px-4 text-right">الوصف</th>
                    <th class="py-3 px-4 text-right">السعر</th>
                    <th class="py-3 px-4 text-right">صورة</th>
                    <th class="py-3 px-4 text-right">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-b hover:bg-emerald-50/30">
                        <td class="py-2 px-4">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 font-bold">{{ $service->name }}</td>
                        <td class="py-2 px-4">{{ $service->description }}</td>
                        <td class="py-2 px-4">{{ number_format($service->price, 2) }} $</td>
                        <td class="py-2 px-4">
                            @if($service->image)
                                <img src="{{ $service->image }}" alt="صورة الخدمة" class="h-12 w-12 object-cover rounded">
                            @else
                                <span class="text-gray-400">لا يوجد</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 flex gap-2">
                            <button wire:click="showEditModal({{ $service->id }})" class="bg-teal-400 hover:bg-teal-500 text-white px-3 py-1 rounded shadow text-xs">تعديل</button>
                            <button wire:click="deleteService({{ $service->id }})" class="bg-red-400 hover:bg-red-500 text-white px-3 py-1 rounded shadow text-xs" onclick="return confirm('هل أنت متأكد من حذف الخدمة؟')">حذف</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-400">لا توجد خدمات مسجلة بعد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center min-h-screen bg-gradient-to-br from-emerald-100/70 to-cyan-100/70">
            <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative flex flex-col items-center justify-center mx-2">
                <button wire:click="$set('showModal', false)" class="absolute top-2 left-2 text-gray-400 hover:text-red-500 text-xl">&times;</button>
                <h3 class="text-xl font-bold mb-4 text-emerald-600">{{ $editMode ? 'تعديل خدمة' : 'إضافة خدمة جديدة' }}</h3>
                <form wire:submit.prevent="saveService" class="space-y-4 w-full">
                    <div>
                        <label class="block mb-1 font-bold text-emerald-700">اسم الخدمة</label>
                        <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2 focus:ring-emerald-300 focus:border-emerald-400">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-bold text-emerald-700">الوصف</label>
                        <textarea wire:model.defer="description" class="w-full border rounded px-3 py-2 focus:ring-emerald-300 focus:border-emerald-400"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-bold text-emerald-700">السعر</label>
                        <input type="number" wire:model.defer="price" step="0.01" class="w-full border rounded px-3 py-2 focus:ring-emerald-300 focus:border-emerald-400">
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-bold text-emerald-700">رابط الصورة (اختياري)</label>
                        <input type="text" wire:model.defer="image" class="w-full border rounded px-3 py-2 focus:ring-emerald-300 focus:border-emerald-400">
                        @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" wire:click="$set('showModal', false)" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">إلغاء</button>
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded font-bold">{{ $editMode ? 'تحديث' : 'إضافة' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
