<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="لوحة تحكم إدارة وكالات السفر">

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>{{ $title ?? 'إدارة الوكالة' }}</title>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [dir="rtl"] .rotate-180 {
            transform: rotate(180deg);
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 min-h-screen font-sans">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo and Agency Name -->
                <div class="flex items-center space-x-4 space-x-reverse">
                    <!-- Agency Logo -->
                    <div class="relative flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/40 shadow-lg">
                            <svg class="h-6 w-6 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Agency Info -->
                    <div>
                        <h1 class="text-xl font-bold text-white truncate max-w-xs">{{ Auth::user()->agency->name ?? 'إدارة الوكالة' }}</h1>
                        <p class="text-xs text-white/80">
                            @switch(true)
                                @case(Auth::user()->isAgencyAdmin())
                                    لوحة تحكم مدير الوكالة
                                    @break
                                @case(Auth::user()->isAgencyUser())
                                    لوحة تحكم مستخدم الوكالة
                                    @break
                                @default
                                    لوحة تحكم الوكالة
                            @endswitch
                        </p>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                    @php
                        $currentRoute = Route::currentRouteName();
                        $navItems = [
                            'dashboard' => [
                                'route' => 'agency.dashboard',
                                'icon' => 'M3 12l2-2m0 0l7-7 7 7M13 5v6h6',
                                'label' => 'لوحة التحكم'
                            ],
                            'agency' => [
                                'route' => 'agency.show',
                                'icon' => 'M4 6h16M4 12h16M4 18h16',
                                'label' => 'بيانات الوكالة'
                            ],
                            'users' => [
                                'route' => 'agency.users',
                                'icon' => 'M17 20h5v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5 M12 7a4 4 0 100 8 4 4 0 000-8z',
                                'label' => 'المستخدمين'
                            ],
                            'roles' => [
                                'route' => 'agency.roles',
                                'icon' => 'M12 6v6h6 M12 12a10 10 0 100-20 10 10 0 000 20z',
                                'label' => 'الأدوار'
                            ],
                            'sales' => [
                                'route' => 'agency.sales.index',
                                'icon' => 'M3 10h11M9 21V3M17 16l4-4m0 0l-4-4m4 4H9',
                                'label' => 'المبيعات'
                            ],
                            'services' => [
                                'route' => 'agency.services',
                                'icon' => 'M8 9l3 3-3 3m5 0h6',
                                'label' => 'الخدمات'
                            ],
                            'permissions' => [
                                'route' => 'agency.permissions',
                                'icon' => 'M5 13l4 4L19 7',
                                'label' => 'الصلاحيات'
                            ],
                            'hr' => [
                                'route' => 'hr.employees.index',
                                'icon' => 'M5.121 17.804A11.938 11.938 0 0112 15c2.21 0 4.265.64 6.001 1.737M15 11a3 3 0 11-6 0 3 3 0 016 0z',
                                'label' => 'الموارد البشرية'
                            ],
                            'lists' => [
                                'route' => 'agency.dynamic-lists',
                                'icon' => 'M4 6h16M4 12h16M4 18h7',
                                'label' => 'إدارة القوائم'
                            ],
                            'profile' => [
                                'route' => 'agency.profile',
                                'icon' => 'M12 4v16m8-8H4',
                                'label' => 'ملف الوكالة'
                            ]
                        ];
                    @endphp

                    @foreach($navItems as $key => $item)
                        <a href="{{ route($item['route']) }}" class="flex flex-col items-center group" title="{{ $item['label'] }}">
                            @if($currentRoute == $item['route'])
                                <span class="text-white font-bold text-sm whitespace-nowrap">{{ $item['label'] }}</span>
                                <div class="h-1 w-6 bg-white rounded-full mt-1"></div>
                            @else
                                <div class="p-2 rounded-full border-2 border-white/20 group-hover:border-white/40 transition-all duration-200">
                                    <svg class="h-6 w-6 text-white group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                                    </svg>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>

                <!-- User Profile and Logout -->
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="h-8 w-8 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/30 shadow-sm">
                            <span class="text-white text-sm font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="text-right hidden md:block">
                            <span class="text-white font-medium text-sm">{{ Auth::user()->name }}</span>
                            <p class="text-xs text-white/80">
                                @switch(true)
                                    @case(Auth::user()->isAgencyAdmin())
                                        مدير الوكالة
                                        @break
                                    @case(Auth::user()->isAgencyUser())
                                        مستخدم الوكالة
                                        @break
                                    @default
                                        مستخدم
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <div class="w-px h-6 bg-white/30 mx-2 hidden md:block"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 flex items-center border-2 border-white/20 hover:border-white/40">
                            <i class="fas fa-sign-out-alt ml-2"></i>
                            <span class="hidden md:inline">تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden" x-show="open" @click.away="open = false" x-transition>
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white/10 backdrop-blur-sm">
                @foreach($navItems as $key => $item)
                    <a href="{{ route($item['route']) }}" class="text-white hover:bg-white/20 block px-3 py-2 rounded-md text-base font-medium flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full px-4 py-6 sm:px-6 lg:px-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-emerald-100 p-6 md:p-8">
            <!-- Flash Messages -->
            @if(session()->has('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <p class="font-bold">حدث خطأ!</p>
                    </div>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white/50 backdrop-blur-sm border-t border-gray-200 mt-8 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600 text-sm">
            <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} - نظام إدارة وكالات السفر</p>
        </div>
    </footer>

    @stack('modals')
    @stack('scripts')
    @livewireScripts

    <script>
        // Initialize Alpine.js
        document.addEventListener('alpine:init', () => {
            Alpine.data('main', () => ({
                open: false,
                darkMode: false,
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    document.documentElement.classList.toggle('dark', this.darkMode);
                    localStorage.setItem('darkMode', this.darkMode);
                },
                init() {
                    // Check for saved dark mode preference
                    if (localStorage.getItem('darkMode') === 'true') {
                        this.darkMode = true;
                        document.documentElement.classList.add('dark');
                    }
                }
            }));
        });

        // Livewire event listeners
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('showToast', (message, type = 'success') => {
                Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "left",
                    backgroundColor: type === 'success' ? "#10B981" : "#EF4444",
                    stopOnFocus: true,
                }).showToast();
            });
        });
    </script>
</body>
</html>
