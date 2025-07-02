<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">ملف الوكالة</h1>
        <p class="text-gray-600">معلومات الوكالة الأساسية</p>
    </div>

    <!-- Agency Info -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">معلومات الوكالة</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">اسم الوكالة</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $agency->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">البريد الإلكتروني</label>
                        <p class="text-gray-800">{{ $agency->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">رقم الهاتف</label>
                        <p class="text-gray-800">{{ $agency->phone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">العنوان</label>
                        <p class="text-gray-800">{{ $agency->address }}</p>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">معلومات الترخيص</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">رقم الترخيص</label>
                        <p class="text-gray-800">{{ $agency->license_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">السجل التجاري</label>
                        <p class="text-gray-800">{{ $agency->commercial_record }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">الرقم الضريبي</label>
                        <p class="text-gray-800">{{ $agency->tax_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">تاريخ انتهاء الرخصة</label>
                        <p class="text-gray-800">{{ $agency->license_expiry_date }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 