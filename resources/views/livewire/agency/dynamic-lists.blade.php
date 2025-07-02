<div class="space-y-6">

    <!-- نموذج إضافة قائمة -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">إضافة قائمة جديدة</h2>
        <form wire:submit.prevent="saveList" class="flex gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm text-gray-600 mb-1">اسم القائمة</label>
                <input type="text" wire:model.defer="listName"
                    class="w-full rounded-md border border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 px-4 py-2 text-sm shadow-sm">
                @error('listName')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded text-sm">حفظ</button>
        </form>
    </div>

    <!-- عرض القوائم -->
    @foreach ($lists as $list)
        <div class="bg-white rounded shadow p-4">
            <div class="flex justify-between items-center">
                <h3 class="text-md font-bold text-gray-800">
                    📦 {{ $list->name }}
                </h3>
                <div class="flex items-center gap-2">
                    <button wire:click="deleteList({{ $list->id }})"
                        onclick="return confirm('هل تريد حذف هذه القائمة؟')"
                        class="transition px-4 py-1 rounded-lg font-medium text-red-600 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500">
                        حذف
                    </button>

                    <button wire:click="toggleExpand({{ $list->id }})"
                        class="text-emerald-600 hover:text-emerald-700 transition duration-200">
                        @if (in_array($list->id, $expandedLists))
                            <!-- سهم لأعلى -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                            </svg>
                        @else
                            <!-- سهم لأسفل -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        @endif
                    </button>

                </div>
            </div>

            @if (in_array($list->id, $expandedLists))
                <div class="mt-4 space-y-2">

                    <!-- العناصر -->
                    @foreach ($list->items as $item)
                        <div class="flex justify-between items-center bg-gray-50 p-2 rounded border">
                            <span class="text-sm text-gray-700">{{ $item->label }}</span>
                            <div class="flex items-center gap-2">
                                <button wire:click="editItem({{ $list->id }}, {{ $item->id }})"
                                    class="transition px-4 py-1 rounded-lg font-medium text-emerald-600 hover:text-white hover:bg-emerald-500 border border-emerald-100 hover:border-emerald-500">
                                    تعديل
                                </button>

                                <button wire:click="deleteItem({{ $list->id }}, {{ $item->id }})"
                                    onclick="return confirm('هل تريد حذف هذا البند؟')"
                                    class="transition px-4 py-1 rounded-lg font-medium text-red-600 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500">
                                    حذف
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <!-- نموذج إضافة أو تعديل بند -->
                    <div class="flex items-end gap-3 mt-2">
                        <input type="text" wire:model.defer="itemLabel.{{ $list->id }}" placeholder="اسم البند"
                            class="w-full rounded-md border border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 px-4 py-2 text-sm shadow-sm">

                        @if (isset($editingItems[$list->id]))
                            <button wire:click="updateItem({{ $list->id }})"
                                class="transition px-4 py-1 rounded-lg font-medium text-blue-600 hover:text-white hover:bg-blue-500 border border-blue-100 hover:border-blue-500">
                                تحديث
                            </button>
                        @else
                            <button wire:click="addItem({{ $list->id }})"
                                class="flex items-center gap-1 text-sm text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-1.5 rounded shadow whitespace-nowrap">
                                <span class="text-base font-bold">+</span>
                                <span class="text-sm">إضافة بند</span>
                            </button>
                        @endif
                    </div>

                    @error('itemLabel.' . $list->id)
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </div>
            @endif
        </div>
    @endforeach

</div>
