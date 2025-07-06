<div class="space-y-6" wire:key="lists-container-{{ $lists->count() }}">
    <!-- عرض جميع القوائم -->
    @foreach ($lists as $list)
        <div class="bg-white rounded-xl shadow p-4 mb-6">
            <!-- رأس القائمة مع خيارات التحكم -->
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-bold text-gray-800">{{ $list->name }}</h3>

                <!-- زر توسيع/طي القائمة -->
                <div class="flex items-center gap-2">
                    <button wire:click="toggleExpand({{ $list->id }})"
                        class="text-gray-500 hover:text-emerald-600 transition"
                        aria-label="{{ in_array($list->id, $expandedLists) ? 'طي القائمة' : 'توسيع القائمة' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 transform transition-transform duration-200"
                            :class="{ 'rotate-180': @js(in_array($list->id, $expandedLists)) }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- محتوى القائمة (يظهر عند التوسيع) -->
            @if (in_array($list->id, $expandedLists))
                <!-- عرض البنود الرئيسية -->
                @foreach ($list->items as $item)
                    <div class="bg-gray-50 border rounded p-3 mb-4 ml-4 space-y-2">
                        <!-- عنوان البند الرئيسي -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-800 font-medium">{{ $item->label }}</span>
                        </div>

                        <!-- قائمة البنود الفرعية -->
                        <ul class="space-y-2">
                            @foreach ($item->subItems as $sub)
                                <li class="flex justify-between items-center pl-4">
                                    @if ($editingSubItemId === $sub->id)
                                        <!-- وضع التعديل للبند الفرعي -->
                                        <form wire:submit.prevent="updateSubItem"
                                            class="flex items-center gap-2 w-full">
                                            <input type="text" wire:model.defer="editingSubItemLabel"
                                                class="flex-1 rounded border px-3 py-1 text-sm focus:ring-emerald-500"
                                                aria-label="تعديل نص البند الفرعي">
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
                                        <!-- وضع العرض العادي للبند الفرعي -->
                                        <span class="text-sm text-gray-600">{{ $sub->label }}</span>
                                        <div class="flex items-center gap-2">
                                            <!-- زر التعديل -->
                                            <button wire:click="startEditSubItem({{ $sub->id }})"
                                                class="text-emerald-700 border border-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                                تعديل
                                            </button>

                                            <!-- زر الحذف (غير متاح للقوائم النظامية) -->
                                            @if (!$list->is_system)
                                                <button wire:click="deleteSubItem({{ $sub->id }})"
                                                    onclick="return confirm('هل أنت متأكد من الحذف؟')"
                                                    class="text-red-600 border border-red-500 hover:bg-red-50 px-3 py-1 rounded-md text-xs font-medium transition">
                                                    حذف
                                                </button>
                                            @endif

                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <!-- نموذج إضافة بند فرعي جديد -->
                        <div class="flex items-center gap-2 mt-2">
                            <input type="text" wire:model.defer="subItemLabel.{{ $item->id }}"
                                placeholder="اسم البند الفرعي"
                                class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-sm"
                                aria-label="إدخال اسم البند الفرعي الجديد">
                            <button wire:click="addSubItem({{ $item->id }})" wire:loading.attr="disabled"
                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-1.5 rounded-md text-xs font-medium border border-emerald-600 whitespace-nowrap transition flex items-center gap-1">
                                <span wire:loading.remove wire:target="addSubItem({{ $item->id }})">+ إضافة</span>
                                <span wire:loading wire:target="addSubItem({{ $item->id }})">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>

                        <!-- رسائل الخطأ -->
                        @error("subItemLabel.$item->id")
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            @endif
        </div>
    @endforeach
</div>

@script
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            /**
             * تأكيد حذف البند الفرعي
             * @param {number} subItemId - معرّف البند الفرعي المراد حذفه
             */
            window.confirmDeleteSubItem = function(subItemId) {
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من التراجع عن هذا الإجراء!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذفه!',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteSubItem', subItemId)
                            .then(() => {
                                // عرض رسالة نجاح باستخدام Toastify
                                Toastify({
                                    text: "تم الحذف بنجاح",
                                    duration: 3000,
                                    backgroundColor: "#10B981",
                                    className: "toastify-success",
                                }).showToast();
                            })
                            .catch(error => {
                                // عرض رسالة خطأ باستخدام Toastify
                                Toastify({
                                    text: "حدث خطأ أثناء الحذف: " + error.message,
                                    duration: 5000,
                                    backgroundColor: "#EF4444",
                                    className: "toastify-error",
                                }).showToast();
                            });
                    }
                });
            };

            // مستمع لحدث نجاح التحديث
            Livewire.on('subitem-updated', () => {
                Toastify({
                    text: "تم تحديث البند الفرعي بنجاح",
                    duration: 3000,
                    backgroundColor: "#10B981",
                    className: "toastify-success",
                }).showToast();
            });
        });
    </script>
@endscript
