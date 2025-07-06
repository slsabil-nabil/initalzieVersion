<div class="space-y-6">
    <!-- قسم إضافة قائمة جديدة (للسوبر أدمن فقط) -->
    @if (auth()->user()?->isSuperAdmin())
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">إضافة قائمة جديدة</h2>
            <form wire:submit.prevent="saveList" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm text-gray-600 mb-1">اسم القائمة</label>
                    <input type="text" wire:model.defer="newListName"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 text-sm shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200">
                    @error('newListName')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-md text-sm font-medium border border-emerald-700 shadow-sm transition">
                    حفظ
                </button>
            </form>
        </div>
    @endif

    <!-- رسائل النظام -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded text-sm shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- عرض القوائم -->
    @foreach ($lists as $list)
        <div class="bg-white rounded-xl shadow p-4 mb-6">
            <!-- رأس القائمة مع خيارات التحكم -->
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-bold text-gray-800">{{ $list->name }}</h3>
                <div class="flex items-center gap-2">
                    <!-- زر توسيع/طي القائمة -->
                    <button wire:click="toggleExpand({{ $list->id }})" class="text-gray-500 hover:text-emerald-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transform transition-transform duration-200"
                             :class="{ 'rotate-180': @js(in_array($list->id, $expandedLists)) }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- خيارات التعديل والحذف للقائمة -->
                    @if ($this->canEditList($list))
                        @if ($editingListId === $list->id)
                            <form wire:submit.prevent="updateList" class="flex items-center gap-2">
                                <input type="text" wire:model.defer="newListName"
                                    class="text-sm border rounded px-2 py-1 focus:ring focus:ring-emerald-300">
                                <button type="submit"
                                    class="bg-green-500 text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-green-600 transition">
                                    حفظ
                                </button>
                                <button type="button" wire:click="$set('editingListId', null)"
                                    class="border border-gray-400 hover:bg-gray-100 px-3 py-1 rounded-md text-xs font-medium text-gray-600 transition">
                                    إلغاء
                                </button>
                            </form>
                        @else
                            <button wire:click="editList({{ $list->id }})"
                                class="text-emerald-700 border border-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                تعديل
                            </button>
                            <button wire:click="deleteList({{ $list->id }})"
                                onclick="return confirmDeleteList({{ $list->id }})"
                                class="text-red-600 border border-red-500 hover:bg-red-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                حذف
                            </button>
                        @endif
                    @endif
                </div>
            </div>

            <!-- محتوى القائمة (يظهر عند التوسيع) -->
            @if (in_array($list->id, $expandedLists))
                <!-- عرض البنود الرئيسية -->
                @foreach ($list->items as $item)
                    <div class="bg-gray-50 border rounded p-3 mb-4 ml-4 space-y-2">
                        <!-- رأس البند الرئيسي -->
                        <div class="flex justify-between items-center">
                            @if ($editingItemId === $item->id)
                                <form wire:submit.prevent="updateItem" class="flex-1">
                                    <input type="text" wire:model.defer="editingItemLabel"
                                        class="w-full rounded-md border border-gray-300 px-3 py-1 text-sm focus:ring-emerald-500">
                                </form>
                            @else
                                <button wire:click="toggleItemExpand({{ $item->id }})" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 transform transition-transform duration-200"
                                        :class="{ 'rotate-90': @js(in_array($item->id, $expandedItems)) }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                    <span class="text-gray-800 font-medium">{{ $item->label }}</span>
                                </button>
                            @endif

                            <!-- خيارات التعديل والحذف للبند الرئيسي -->
                            @if ($this->canEditItem($item))
                                <div class="flex items-center gap-2">
                                    @if ($editingItemId === $item->id)
                                        <button type="submit" wire:click="updateItem"
                                            class="text-green-700 border border-green-600 hover:bg-green-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                            حفظ
                                        </button>
                                        <button type="button" wire:click="$set('editingItemId', null)"
                                            class="text-gray-600 border border-gray-500 hover:bg-gray-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                            إلغاء
                                        </button>
                                    @else
                                        <button wire:click="startEditItem({{ $item->id }})"
                                            class="text-emerald-700 border border-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                            تعديل
                                        </button>
                                        <button wire:click="deleteItem({{ $item->id }})"
                                            onclick="return confirmDeleteItem({{ $item->id }})"
                                            class="text-red-600 border border-red-500 hover:bg-red-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                            حذف
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- البنود الفرعية (تظهر عند توسيع البند الرئيسي) -->
                        @if(in_array($item->id, $expandedItems))
                            @foreach ($item->subItems as $sub)
                                <div class="flex justify-between items-center gap-2 pl-8 text-sm">
                                    @if ($editingSubItemId === $sub->id)
                                        <form wire:submit.prevent="updateSubItem" class="flex items-center gap-2 w-full">
                                            <input type="text" wire:model.defer="editingSubItemLabel"
                                                class="flex-1 rounded border px-3 py-1 text-sm focus:ring-emerald-500">
                                            <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded-md text-xs font-medium hover:bg-green-600 transition">
                                                حفظ
                                            </button>
                                            <button type="button" wire:click="$set('editingSubItemId', null)"
                                                class="border border-gray-400 hover:bg-gray-100 px-3 py-1 rounded-md text-xs font-medium text-gray-600 transition">
                                                إلغاء
                                            </button>
                                        </form>
                                    @else
                                        <span>{{ $sub->label }}</span>
                                        <!-- خيارات التعديل والحذف للبند الفرعي -->
                                        @if ($this->canEditSub($sub))
                                            <div class="flex items-center gap-2">
                                                <button wire:click="startEditSubItem({{ $sub->id }})"
                                                    class="text-emerald-700 border border-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                                    تعديل
                                                </button>
                                                <button wire:click="deleteSubItem({{ $sub->id }})"
                                                    onclick="return confirmDeleteSubItem({{ $sub->id }})"
                                                    class="text-red-600 border border-red-500 hover:bg-red-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                                    حذف
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endforeach

                            <!-- نموذج إضافة بند فرعي جديد -->
                            <div class="flex items-center gap-2 mt-2 pl-8">
                                <input type="text" wire:model.defer="subItemLabel.{{ $item->id }}"
                                    placeholder="اسم البند الفرعي"
                                    class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-sm">
                                <button wire:click="addSubItem({{ $item->id }})"
                                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-1.5 rounded-md text-xs font-medium border border-emerald-600 whitespace-nowrap transition">
                                    + إضافة بند فرعي
                                </button>
                            </div>
                            @error("subItemLabel.$item->id")
                                <span class="text-red-500 text-xs pl-8">{{ $message }}</span>
                            @enderror
                        @endif
                    </div>
                @endforeach

                <!-- نموذج إضافة بند رئيسي جديد -->
                <div class="flex items-center gap-2 ml-4 mt-2">
                    <input type="text" wire:model.defer="itemLabel.{{ $list->id }}" placeholder="اسم البند"
                        class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-sm">
                    <button wire:click="addItem({{ $list->id }})"
                        class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-1.5 rounded-md text-xs font-medium border border-emerald-600 whitespace-nowrap transition">
                        + إضافة بند
                    </button>
                </div>
                @error("itemLabel.$list->id")
                    <span class="text-red-500 text-xs ml-8">{{ $message }}</span>
                @enderror
            @endif
        </div>
    @endforeach
</div>

@script
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        /**
         * تأكيد حذف القائمة مع جميع بنودها
         * @param {number} listId - معرّف القائمة المراد حذفها
         */
        window.confirmDeleteList = function(listId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف القائمة وجميع بنودها!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف القائمة',
                cancelButtonText: 'إلغاء',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteList', listId)
                        .then(() => {
                            Swal.fire('تم الحذف!', 'تم حذف القائمة بنجاح.', 'success');
                        });
                }
            });
        };

        /**
         * تأكيد حذف البند الرئيسي مع جميع بنوده الفرعية
         * @param {number} itemId - معرّف البند المراد حذفه
         */
        window.confirmDeleteItem = function(itemId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف البند وجميع بنوده الفرعية!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف البند',
                cancelButtonText: 'إلغاء',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteItem', itemId)
                        .then(() => {
                            Swal.fire('تم الحذف!', 'تم حذف البند بنجاح.', 'success');
                        });
                }
            });
        };

        /**
         * تأكيد حذف البند الفرعي
         * @param {number} subItemId - معرّف البند الفرعي المراد حذفه
         */
        window.confirmDeleteSubItem = function(subItemId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف البند الفرعي!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف البند',
                cancelButtonText: 'إلغاء',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteSubItem', subItemId)
                        .then(() => {
                            Swal.fire('تم الحذف!', 'تم حذف البند الفرعي بنجاح.', 'success');
                        });
                }
            });
        };

        // إعداد مستمعين لأحداث Livewire لعرض رسائل النجاح
        Livewire.on('list-saved', () => {
            Swal.fire('تم الحفظ!', 'تم حفظ القائمة بنجاح.', 'success');
        });

        Livewire.on('item-saved', () => {
            Swal.fire('تم الحفظ!', 'تم حفظ البند بنجاح.', 'success');
        });

        Livewire.on('subitem-saved', () => {
            Swal.fire('تم الحفظ!', 'تم حفظ البند الفرعي بنجاح.', 'success');
        });
    });
</script>
@endscript
