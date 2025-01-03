<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = session('login_user');
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('web.home', absolute: false).'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            // TODO: ドメインモデルを引数に取るよう修正
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('web.home', absolute: false).'?verified=1');
    }
}
