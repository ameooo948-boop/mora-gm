<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = $this->authService->register(
            $request->validated()
        );

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('verification.notice')
            ->with(
                'success',
                'تم إنشاء حسابك بنجاح. يُرجى تفعيل بريدك الإلكتروني.'
            );
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $authenticated = $this->authService->attemptLogin(
            $request->string('email')->toString(),
            $request->string('password')->toString(),
            $request->boolean('remember')
        );

        if (! $authenticated) {
            return back()
                ->withErrors([
                    'email' => 'بيانات تسجيل الدخول التي أدخلتها غير صحيحة.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->intended(
                route('admin.dashboard')
            );
        }

        if ($user->isMember()) {
            return redirect()->intended(
                route('member.dashboard')
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        abort(403, 'نوع الحساب غير مسموح به.');
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
