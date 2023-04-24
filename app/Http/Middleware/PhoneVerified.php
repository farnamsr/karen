<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VerificationMessage;

class PhoneVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $phone = explode("/",url()->current())[5];
        $verified = VerificationMessage::where("phone_number", $phone)
            ->where("status", VerificationMessage::STATUS_VERIFIED)->first();
        $existedUser = User::where("phone_number", $phone)->first();
        if(! $verified && !$existedUser) {
            abort(403);
        }
        return $next($request);
    }
}
