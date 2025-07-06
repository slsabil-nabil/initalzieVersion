<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow space-y-8">
    <h1 class="text-2xl font-bold text-emerald-700 text-center">تهيئة بيانات الوكالة</h1>

    @if ($alreadyInitialized)
        <!-- ✅ الشعار وبيانات الوكالة الغير قابلة للتعديل -->
        <div class="flex flex-col md:flex-row items-center gap-10">
            <!-- صورة الشعار -->
            <div class="w-36 h-36 flex items-center justify-center">
                <img src="{{ asset('storage/' . Auth::user()->agency->setting->logo) }}"
                     alt="شعار الوكالة"
                     class="w-32 h-32 rounded-full object-cover shadow border" />
            </div>

            <!-- بيانات الوكالة -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                <div>
                    <label class="block text-sm text-gray-500 font-medium mb-1">اسم الوكالة</label>
                    <p class="bg-gray-100 border rounded px-4 py-2 text-sm text-gray-700">{{ $agency_name }}</p>
                </div>

                <div>
                    <label class="block text-sm text-gray-500 font-medium mb-1">اسم الفرع الرئيسي</label>
                    <p class="bg-gray-100 border rounded px-4 py-2 text-sm text-gray-700">{{ $main_branch_name }}</p>
                </div>

                <div>
                    <label class="block text-sm text-gray-500 font-medium mb-1">العملة</label>
                    <p class="bg-gray-100 border rounded px-4 py-2 text-sm text-gray-700">{{ $currency }}</p>
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-300">

        <!-- ✅ نموذج تعديل بيانات الاتصال فقط -->
        <form wire:submit.prevent="updateContactInfo" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">رقم الهاتف</label>
                <input type="text" wire:model.defer="phone"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm shadow-sm focus:ring focus:ring-emerald-200">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">رقم الهاتف الثابت</label>
                <input type="text" wire:model.defer="landline"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm shadow-sm focus:ring focus:ring-emerald-200">
                @error('landline') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">البريد الإلكتروني</label>
                <input type="email" wire:model.defer="email"
                       class="w-full border border-gray-300 rounded px-4 py-2 text-sm shadow-sm focus:ring focus:ring-emerald-200">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2 text-center">
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg shadow transition">
                    حفظ التعديلات
                </button>
            </div>
        </form>

    @else
        <!-- ✅ نموذج التهيئة لأول مرة -->
        <form wire:submit.prevent="save" class="space-y-6">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">شعار الوكالة</label>
                <input type="file" wire:model="logo"
                       class="w-full border rounded px-3 py-2 text-sm" accept="image/*">
                @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">اسم الوكالة</label>
                    <input type="text" wire:model.defer="agency_name"
                           class="w-full border rounded px-3 py-2 text-sm">
                    @error('agency_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">اسم الفرع الرئيسي</label>
                    <input type="text" wire:model.defer="main_branch_name"
                           class="w-full border rounded px-3 py-2 text-sm">
                    @error('main_branch_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">العملة</label>
                    <input type="text" wire:model.defer="currency"
                           class="w-full border rounded px-3 py-2 text-sm">
                    @error('currency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="my-4 border-gray-300">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">رقم الهاتف</label>
                    <input type="text" wire:model.defer="phone"
                           class="w-full border rounded px-3 py-2 text-sm">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">رقم الهاتف الثابت</label>
                    <input type="text" wire:model.defer="landline"
                           class="w-full border rounded px-3 py-2 text-sm">
                    @error('landline') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">البريد الإلكتروني</label>
                    <input type="email" wire:model.defer="email"
                           class="w-full border rounded px-3 py-2 text-sm">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="text-center">
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg shadow">
                    حفظ البيانات
                </button>
            </div>
        </form>
    @endif
</div>
