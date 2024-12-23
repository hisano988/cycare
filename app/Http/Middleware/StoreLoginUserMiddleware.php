<?php

namespace App\Http\Middleware;

use App\Domain\Repositories\UserRepository;
use App\Exception\UserNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreLoginUserMiddleware
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Request $request, $next)
    {
        $loginId = Auth::id();
        if (is_null($loginId)) {
            return redirect()->route('login');
        }
        $loginUser = $this->userRepository->find($loginId);
        if (is_null($loginUser)) {
            throw new UserNotFoundException;
        }

        session()->now('login_user', $loginUser);

        return $next($request);
    }
}
