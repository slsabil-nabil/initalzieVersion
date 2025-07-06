<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $showPassword = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'البريد الإلكتروني مطلوب',
        'email.email' => 'يرجى إدخال بريد إلكتروني صحيح',
        'password.required' => 'كلمة المرور مطلوبة',
        'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $user = Auth::user();

            // التحقق من أن المستخدم نشط
            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['تم تعطيل حسابك. يرجى التواصل مع الإدارة.'],
                ]);
            }

            // تحديث آخر تسجيل دخول
            $user->update(['last_login_at' => now()]);

            session()->flash('message', 'تم تسجيل الدخول بنجاح!');

            // ✅ إعادة التوجيه دائمًا إلى /dashboard ليتم التحقق هناك
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => ['بيانات الاعتماد المقدمة غير صحيحة.'],
        ]);
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.login')
            ->layout('layouts.app')
            ->title('تسجيل الدخول - نظام إدارة وكالات السفر');
    }
}
