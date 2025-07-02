<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-200 via-teal-100 to-cyan-200 p-4">
    <div class="w-full max-w-md">
        <div class="bg-white/90 rounded-3xl shadow-2xl p-8 space-y-8 border border-emerald-100 backdrop-blur-md">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-gradient-to-tr from-emerald-400 via-teal-300 to-cyan-400 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <svg class="h-8 w-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-emerald-700 mb-1 drop-shadow">تسجيل الدخول</h2>
                <p class="text-emerald-400 font-medium">مرحباً بعودتك! أدخل بياناتك للمتابعة</p>
            </div>

            <form wire:submit.prevent="login" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-bold text-emerald-600 mb-2">البريد الإلكتروني</label>
                    <div class="relative">
                        <input
                            wire:model="email"
                            type="email"
                            id="email"
                            class="block w-full pl-10 pr-3 py-3 border border-teal-200 rounded-xl focus:ring-2 focus:ring-emerald-300 focus:border-emerald-400 transition duration-200 bg-white/80 placeholder-teal-300 text-emerald-700 font-semibold shadow-sm @error('email') border-red-400 focus:ring-red-200 focus:border-red-400 @enderror"
                            placeholder="example@email.com"
                            dir="ltr"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-emerald-600 mb-2">كلمة المرور</label>
                    <div class="relative">
                        <input
                            wire:model="password"
                            type="{{ $showPassword ? 'text' : 'password' }}"
                            id="password"
                            class="block w-full pl-10 pr-12 py-3 border border-teal-200 rounded-xl focus:ring-2 focus:ring-emerald-300 focus:border-emerald-400 transition duration-200 bg-white/80 placeholder-teal-300 text-emerald-700 font-semibold shadow-sm @error('password') border-red-400 focus:ring-red-200 focus:border-red-400 @enderror"
                            placeholder="••••••••"
                            dir="ltr"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <button
                            type="button"
                            wire:click="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-emerald-400 hover:text-teal-500 focus:outline-none"
                        >
                            @if($showPassword)
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            @else
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            @endif
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            wire:model="remember"
                            id="remember"
                            type="checkbox"
                            class="h-4 w-4 text-emerald-400 focus:ring-emerald-300 border-teal-200 rounded"
                        >
                        <label for="remember" class="mr-2 block text-xs text-emerald-500 font-semibold">تذكرني</label>
                    </div>
                    <div class="text-xs">
                        <a href="/forgot-password" class="font-medium text-emerald-400 hover:text-teal-500 transition">نسيت كلمة المرور؟</a>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400 shadow-lg hover:from-emerald-500 hover:to-cyan-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-200 transition duration-200 transform hover:scale-105"
                    >
                        تسجيل الدخول
                    </button>
                </div>
            </form>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-teal-100"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-2 bg-white/90 text-teal-300 font-bold">أو</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button class="w-full inline-flex justify-center py-2 px-4 border border-emerald-100 rounded-xl shadow-sm bg-white/80 text-xs font-bold text-emerald-400 hover:bg-emerald-50 transition">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google
                </button>
                <button class="w-full inline-flex justify-center py-2 px-4 border border-teal-100 rounded-xl shadow-sm bg-white/80 text-xs font-bold text-teal-400 hover:bg-teal-50 transition">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </button>
            </div>

            <div class="text-center">
                <p class="text-xs text-emerald-400 font-semibold mt-4">
                    للوصول إلى النظام، يرجى التواصل مع الإدارة
                </p>
            </div>
        </div>
        <div class="text-center mt-6">
            <p class="text-xs text-emerald-300">© 2024 جميع الحقوق محفوظة</p>
        </div>
    </div>
</div>
