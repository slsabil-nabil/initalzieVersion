<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">مرحباً بك في {{ $agency->name }}</h1>
        <p class="text-gray-600">
            @if($user->isAgencyAdmin())
                لوحة تحكم مدير الوكالة لإدارة المستخدمين والأدوار والصلاحيات والخدمات
            @elseif($user->isAgencyUser())
                لوحة تحكم مستخدم الوكالة
            @else
                لوحة تحكم الوكالة
            @endif
        </p>
    </div>

    <!-- Agency Info Card (for admins only) -->
    @if($user->isAgencyAdmin() && isset($permissionStats['agency']))
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg shadow-md p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">{{ $agency->name }}</h2>
                <p class="text-emerald-100 mb-1">{{ $agency->email }}</p>
                <p class="text-emerald-100">{{ $agency->phone }}</p>
                <p class="text-emerald-100 mt-2">{{ $agency->address }}</p>
                @if($permissionStats['agency']['isLicenseExpired'])
                    <div class="mt-2 p-2 bg-red-500 bg-opacity-20 rounded-lg">
                        <p class="text-red-200 text-sm">⚠️ انتهت صلاحية الترخيص</p>
                    </div>
                @elseif($permissionStats['agency']['daysUntilExpiry'] <= 30)
                    <div class="mt-2 p-2 bg-yellow-500 bg-opacity-20 rounded-lg">
                        <p class="text-yellow-200 text-sm">⚠️ ينتهي الترخيص خلال {{ $permissionStats['agency']['daysUntilExpiry'] }} يوم</p>
                    </div>
                @endif
            </div>
            <div class="text-right">
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <p class="text-sm text-emerald-100">رقم الترخيص</p>
                    <p class="text-xl font-bold">{{ $agency->license_number }}</p>
                    <p class="text-xs text-emerald-100 mt-1">الحد الأقصى: {{ $permissionStats['agency']['maxUsers'] }} مستخدم</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Users Statistics -->
        @if(isset($permissionStats['users']))
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">إجمالي المستخدمين</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $permissionStats['users']['total'] }}</p>
                    <p class="text-xs text-green-600">{{ $permissionStats['users']['active'] }} نشط</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Roles Statistics -->
        @if(isset($permissionStats['roles']))
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">الأدوار المخصصة</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $permissionStats['roles']['total'] }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Services Statistics -->
        @if(isset($permissionStats['services']))
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0a2 2 0 002 2h2a2 2 0 002-2m-6 0V7a2 2 0 012-2h2a2 2 0 012 2v10"></path>
                    </svg>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">إجمالي الخدمات</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $permissionStats['services']['total'] }}</p>
                    <p class="text-xs text-green-600">{{ $permissionStats['services']['active'] }} نشط</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Agency Status (for admins only) -->
        @if($user->isAgencyAdmin() && isset($permissionStats['agency']))
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full {{ $permissionStats['agency']['status'] === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">حالة الوكالة</p>
                    <p class="text-2xl font-bold {{ $permissionStats['agency']['status'] === 'active' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $permissionStats['agency']['status'] === 'active' ? 'نشطة' : 'غير نشطة' }}
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    @if($user->isAgencyAdmin())
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">إجراءات سريعة</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($user->hasPermission('users.create'))
            <a href="{{ route('agency.users') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-emerald-50 hover:border-emerald-300 transition duration-200">
                <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">إضافة مستخدم جديد</h3>
                    <p class="text-sm text-gray-600">إضافة مستخدم جديد للوكالة</p>
                </div>
            </a>
            @endif
            
            @if($user->hasPermission('roles.create'))
            <a href="{{ route('agency.roles') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-emerald-50 hover:border-emerald-300 transition duration-200">
                <div class="p-2 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">إدارة الأدوار</h3>
                    <p class="text-sm text-gray-600">إنشاء وتعديل أدوار المستخدمين</p>
                </div>
            </a>
            @endif

            @if($user->hasPermission('services.create'))
            <a href="{{ route('agency.services') }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-emerald-50 hover:border-emerald-300 transition duration-200">
                <div class="p-2 rounded-full bg-emerald-100 text-emerald-600 mr-4">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">إضافة خدمة جديدة</h3>
                    <p class="text-sm text-gray-600">إضافة خدمة جديدة للوكالة</p>
                </div>
            </a>
            @endif
        </div>
    </div>
    @endif

    <!-- Recent Data Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        @if(isset($permissionStats['users']))
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">آخر المستخدمين المضافة</h2>
                    @if($user->hasPermission('users.view'))
                    <a href="{{ route('agency.users') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                        عرض الكل
                    </a>
                    @endif
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المستخدم</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الدور</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permissionStats['users']['recent'] as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-emerald-600 font-semibold text-sm">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ $user->role->display_name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500">بدون دور</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->is_active)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">غير نشط</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">لا يوجد مستخدمين</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Recent Services -->
        @if(isset($permissionStats['services']))
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">آخر الخدمات المضافة</h2>
                    @if($user->hasPermission('services.view'))
                    <a href="{{ route('agency.services') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                        عرض الكل
                    </a>
                    @endif
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الخدمة</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permissionStats['services']['recent'] as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0a2 2 0 002 2h2a2 2 0 002-2m-6 0V7a2 2 0 012-2h2a2 2 0 012 2v10"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                            <div class="text-xs text-gray-500">{{ Str::limit($service->description, 30) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($service->price, 2) }} ريال
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($service->status === 'active')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">نشط</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">غير نشط</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">لا توجد خدمات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Welcome Message for Regular Users -->
    @if($user->isAgencyUser() && !isset($permissionStats['users']) && !isset($permissionStats['services']))
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-md p-8 text-white text-center">
        <div class="max-w-md mx-auto">
            <div class="h-16 w-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold mb-2">مرحباً بك في {{ $agency->name }}</h2>
            <p class="text-blue-100">يمكنك الوصول إلى الوظائف المتاحة لك من القائمة الجانبية</p>
        </div>
    </div>
    @endif
</div>
