<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\RedirectResponse;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public bool $showPassword = false;
    public int $attemptsRemaining = 5;
    public bool $showAttemptsWarning = false;

    protected array $rules = [
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:6|max:255',
    ];

    protected array $messages = [
        'email.required' => 'البريد الإلكتروني مطلوب',
        'email.email' => 'يرجى إدخال بريد إلكتروني صحيح',
        'email.max' => 'البريد الإلكتروني يجب أن لا يتجاوز 255 حرفاً',
        'password.required' => 'كلمة المرور مطلوبة',
        'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        'password.max' => 'كلمة المرور يجب أن لا تتجاوز 255 حرفاً',
    ];

    public function mount(): void
    {
        if (Auth::check()) {
            redirect()->route('dashboard');
        }
    }

    public function login(): ?RedirectResponse
    {
        $this->validate();

        // Rate limiting check
        if ($this->hasTooManyLoginAttempts()) {
            $this->showAttemptsWarning = true;
            $this->addError('email', 'لقد تجاوزت عدد المحاولات المسموح بها. يرجى المحاولة لاحقاً.');
            return null;
        }

        if (!Auth::attempt($this->credentials(), $this->remember)) {
            $this->incrementLoginAttempts();
            $this->updateAttemptsRemaining();

            throw ValidationException::withMessages([
                'email' => __('بيانات الاعتماد المقدمة غير صحيحة.'),
            ]);
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => __('تم تعطيل حسابك. يرجى التواصل مع الإدارة.'),
            ]);
        }

        // Reset rate limiter on successful login
        $this->clearLoginAttempts();

        // Update last login
        $user->update(['last_login_at' => now()]);

        session()->flash('success', __('تم تسجيل الدخول بنجاح!'));

        return redirect()->intended(route('dashboard'));
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.login')
            ->layout('layouts.app', [
                'title' => 'تسجيل الدخول - نظام إدارة وكالات السفر',
                'description' => 'صفحة تسجيل الدخول لنظام إدارة وكالات السفر'
            ]);
    }

    protected function credentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    protected function hasTooManyLoginAttempts(): bool
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey(),
            5, // Max attempts
            60 // Decay minutes
        );
    }

    protected function incrementLoginAttempts(): void
    {
        RateLimiter::hit($this->throttleKey());
    }

    protected function clearLoginAttempts(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    protected function updateAttemptsRemaining(): void
    {
        $this->attemptsRemaining = max(0, 5 - RateLimiter::attempts($this->throttleKey()));
    }

    protected function throttleKey(): string
    {
        return 'login:' . request()->ip();
    }
}
