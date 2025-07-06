<div class="bg-white shadow-md rounded-xl p-6 space-y-6">

    <!-- العنوان -->
    <div class="text-right">
        <h2 class="text-2xl font-bold text-emerald-700">بيانات الشركة</h2>
    </div>

    <!-- صورة الشعار + بيانات الوكالة -->
    <div class="flex flex-col md:flex-row gap-6 items-start justify-start">

        <!-- صورة الشعار -->
        <div class="md:w-1/5 flex justify-center md:justify-start">
            <img src="{{ asset('storage/' . $setting->logo) }}" alt="شعار الشركة"
                class="w-28 h-28 rounded-full border border-gray-300 object-cover shadow-md">
        </div>

        <!-- بيانات الوكالة -->
        <div class="md:w-4/5 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">اسم الشركة</label>
                <p class="bg-gray-50 border rounded-md px-3 py-2 text-sm font-medium text-gray-800">
                    {{ $setting->agency_name }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">اسم الفرع الرئيسي</label>
                <p class="bg-gray-50 border rounded-md px-3 py-2 text-sm font-medium text-gray-800">
                    {{ $setting->main_branch_name }}

                </p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">العملة</label>
                <p class="bg-gray-50 border rounded-md px-3 py-2 text-sm font-medium text-gray-800">
                    {{ $setting->currency }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">رقم الهاتف</label>
                <input type="text" wire:model.debounce.500ms="phone"
                    class="w-full text-center border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">رقم الثابت</label>
                <input type="text" wire:model.debounce.500ms="landline"
                    class="w-full text-center border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">الإيميل</label>
                <input type="email" wire:model.debounce.500ms="email"
                    class="w-full text-center border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500">
            </div>

        </div>
    </div>

    <!-- الفروع -->
    <div class="space-y-6 mt-8">
        <h3 class="text-xl font-bold text-gray-700 border-b pb-2">فروع الوكالة</h3>

        <!-- نموذج الإضافة -->
        <form wire:submit.prevent="addBranch"
            class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg shadow-sm">
            <input type="text" wire:model.defer="branchName" placeholder="اسم الفرع"
                class="border px-3 py-2 rounded w-full text-sm">
            <input type="text" wire:model.defer="branchPhone" placeholder="رقم الهاتف"
                class="border px-3 py-2 rounded w-full text-sm">
            <input type="email" wire:model.defer="branchEmail" placeholder="البريد الإلكتروني"
                class="border px-3 py-2 rounded w-full text-sm">
            <input type="text" wire:model.defer="branchAddress" placeholder="العنوان"
                class="border px-3 py-2 rounded w-full text-sm">

            <div class="md:col-span-4 text-left">
                <button class="bg-emerald-600 text-white px-6 py-2 rounded hover:bg-emerald-700">إضافة فرع</button>
            </div>
        </form>

        <!-- عرض الفروع -->

        <div class="flex flex-col space-y-4">
            @forelse($branches as $branch)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h4 class="text-xl font-bold text-emerald-700 mb-2">{{ $branch->name }}</h4>

                    <div class="text-sm text-gray-600 space-y-1 leading-relaxed">
                        @if ($branch->phone)
                            <div><span class="text-rose-600">📞</span> الهاتف: <span
                                    class="font-medium">{{ $branch->phone }}</span></div>
                        @endif

                        @if ($branch->email)
                            <div><span class="text-purple-600">📧</span> الإيميل: <span
                                    class="font-medium">{{ $branch->email }}</span></div>
                        @endif

                        @if ($branch->address)
                            <div><span class="text-pink-600">📍</span> العنوان: <span
                                    class="font-medium">{{ $branch->address }}</span></div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">لا توجد فروع مسجلة.</p>
            @endforelse
        </div>



    </div>


    <!-- زر الحفظ -->
    <div class="text-left mt-6">
        <button wire:click="save" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg">
            حفظ
        </button>
    </div>

    @if (session()->has('success'))
        <div class="mt-4 text-green-600 font-semibold text-sm text-center">
            {{ session('success') }}
        </div>
    @endif

</div>
