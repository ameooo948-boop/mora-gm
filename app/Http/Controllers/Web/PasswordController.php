<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendPasswordResetLinkRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showForgotForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(
        SendPasswordResetLinkRequest $request
    ): RedirectResponse {
        $status = Password::sendResetLink(
            $request->validated()
        );

        if ($status === Password::RESET_THROTTLED) {
            return back()
                ->withErrors([
                    'email' => 'تم إرسال طلبات كثيرة، حاول مرة أخرى بعد قليل.',
                ])
                ->onlyInput('email');
        }

        if ($status !== Password::RESET_LINK_SENT && $status !== Password::INVALID_USER) {
            return back()
                ->withErrors([
                    'email' => 'تعذر إرسال رابط إعادة تعيين كلمة المرور. حاول مرة أخرى.',
                ])
                ->onlyInput('email');
        }

        return back()->with(
            'success',
            'إذا كان البريد الإلكتروني مرتبطًا بحساب، فسيتم إرسال رابط إعادة تعيين كلمة المرور إليه.'
        );
    }

    public function showResetForm(string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->query('email'),
        ]);
    }

    public function reset(
        ResetPasswordRequest $request
    ): RedirectResponse {
        $status = Password::reset(
            $request->validated(),
            function ($user, $password): void {
                $this->authService->resetPassword($user, $password);
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors([
                'email' => match ($status) {
                    Password::INVALID_TOKEN =>
                        'رابط إعادة تعيين كلمة المرور غير صالح أو انتهت صلاحيته.',
                    Password::INVALID_USER =>
                        'لا يوجد حساب مرتبط بهذا البريد الإلكتروني.',
                    Password::RESET_THROTTLED =>
                        'تم إرسال طلبات كثيرة، حاول مرة أخرى بعد قليل.',
                    default =>
                        'تعذر إعادة تعيين كلمة المرور. حاول مرة أخرى.',
                },
            ]);
        }

        return redirect()
            ->route('login')
            ->with(
                'success',
                'تمت إعادة تعيين كلمة المرور بنجاح.'
            );
    }
}
