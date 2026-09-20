<?php

use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\GymProfileController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\MembershipPlanController as AdminMembershipPlanController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\TrainingSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\AttendanceController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\MembershipController;
use App\Http\Controllers\Member\NotificationController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\SubscriptionController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/forgot-password', [
        PasswordController::class,
        'showForgotForm',
    ])->name('password.request');

    Route::post('/forgot-password', [
        PasswordController::class,
        'sendResetLink',
    ])->name('password.email');

    Route::get('/reset-password/{token}', [
        PasswordController::class,
        'showResetForm',
    ])->name('password.reset');

    Route::post('/reset-password', [
        PasswordController::class,
        'reset',
    ])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'verified', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {

        Route::get('/dashboard', [MemberDashboardController::class, 'index'])
            ->name('dashboard');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/payments', [
            AdminPaymentController::class,
            'index',
        ])->name('payments.index');

        Route::post('/payments/{payment}/approve', [
            AdminPaymentController::class,
            'approve',
        ])->name('payments.approve');

        Route::post('/payments/{payment}/reject', [
            AdminPaymentController::class,
            'reject',
        ])->name('payments.reject');

        Route::get('/attendance', [
            AdminAttendanceController::class,
            'index',
        ])->name('attendance.index');

        Route::get('/members', [
            MemberController::class,
            'index',
        ])->name('members.index');

        Route::get('/members/{member}', [
            MemberController::class,
            'show',
        ])->name('members.show');

        Route::get('/subscriptions', [
            AdminSubscriptionController::class,
            'index',
        ])->name('subscriptions.index');

        Route::get('/subscriptions/{subscription}', [
            AdminSubscriptionController::class,
            'show',
        ])->name('subscriptions.show');

        Route::put('/members/{member}', [
            MemberController::class,
            'update',
        ])->name('members.update');

        Route::get('/training-sessions', [TrainingSessionController::class, 'index'])
            ->name('training-sessions.index');

        Route::get('/training-sessions/create', [TrainingSessionController::class, 'create'])
            ->name('training-sessions.create');

        Route::post('/training-sessions', [TrainingSessionController::class, 'store'])
            ->name('training-sessions.store');

        Route::get('/training-sessions/{trainingSession}/edit', [TrainingSessionController::class, 'edit'])
            ->name('training-sessions.edit');

        Route::put('/training-sessions/{trainingSession}', [TrainingSessionController::class, 'update'])
            ->name('training-sessions.update');

        Route::get('/trainers', [TrainerController::class, 'index'])
            ->name('trainers.index');

        Route::get('/trainers/create', [TrainerController::class, 'create'])
            ->name('trainers.create');

        Route::post('/trainers', [TrainerController::class, 'store'])
            ->name('trainers.store');

        Route::get('/trainers/{trainer}/edit', [TrainerController::class, 'edit'])
            ->name('trainers.edit');

        Route::put('/trainers/{trainer}', [TrainerController::class, 'update'])
            ->name('trainers.update');

        Route::resource('membership-plans', AdminMembershipPlanController::class)
            ->only(['index', 'create', 'store', 'edit', 'update'])
            ->names('membership-plans');

        Route::resource('gym-profile', GymProfileController::class)
            ->only(['index', 'create', 'store', 'edit', 'update'])
            ->names('gym-profile');

        Route::get('/gallery', [GalleryItemController::class, 'index'])
            ->name('gallery.index');

        Route::get('/gallery/create', [GalleryItemController::class, 'create'])
            ->name('gallery.create');

        Route::post('/gallery', [GalleryItemController::class, 'store'])
            ->name('gallery.store');

        Route::get('/gallery/{id}/edit', [GalleryItemController::class, 'edit'])
            ->name('gallery.edit');

        Route::put('/gallery/{id}', [GalleryItemController::class, 'update'])
            ->name('gallery.update');

        Route::delete('/gallery/{id}', [GalleryItemController::class, 'destroy'])
            ->name('gallery.destroy');
    });

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', function (): View {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (
        EmailVerificationRequest $request
    ): RedirectResponse {
        $request->fulfill();

        return redirect()
            ->route('member.dashboard')
            ->with('success', 'Your email has been verified successfully.');
    })
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', function (
        Request $request
    ): RedirectResponse {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('member.dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with(
            'success',
            'A new verification link has been sent to your email.'
        );
    })
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::middleware(['auth', 'verified', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/dashboard', [
            MemberDashboardController::class,
            'index',
        ])->name('dashboard');

        Route::get('/subscription', [
            SubscriptionController::class,
            'index',
        ])->name('subscription');

        Route::get('/payment/{payment}', [
            PaymentController::class,
            'show',
        ])->name('payment.show');

        Route::post('/payment/{payment}', [
            PaymentController::class,
            'submit',
        ])->name('payment.submit');

        Route::post('/membership/{membershipPlan}/subscribe', [
            MembershipController::class,
            'subscribe',
        ])->name('membership.subscribe');

        Route::get('/attendance', [
            AttendanceController::class,
            'index',
        ])->name('attendance');

        Route::post('/attendance/{trainingSession}/check-in', [
            AttendanceController::class,
            'checkIn',
        ])->name('attendance.check-in');

        Route::post('/attendance/{trainingSession}/check-out', [
            AttendanceController::class,
            'checkOut',
        ])->name('attendance.check-out');

        Route::get('/profile', [
            ProfileController::class,
            'edit',
        ])->name('profile');

        Route::put('/profile', [
            ProfileController::class,
            'update',
        ])->name('profile.update');

        Route::get('/notifications', [
            NotificationController::class,
            'index',
        ])->name('notifications');

        Route::post('/notifications/{notification}/read', [
            NotificationController::class,
            'markAsRead',
        ])->name('notifications.read');

        Route::post('/notifications/read-all', [
            NotificationController::class,
            'markAllAsRead',
        ])->name('notifications.read-all');
    });
