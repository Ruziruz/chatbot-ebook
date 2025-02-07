<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ReferralCode;

class ReferralMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('referral_code')) {
            return $next($request);
        }

        if ($request->has('code')) {
            $code = $request->input('code');

            if (ReferralCode::where('code', $code)->exists()) {
                $request->session()->put('referral_code', $code);
                return $next($request);
            } else {
                return redirect('/referral')->withErrors(['code' => 'Kode referral tidak valid!']);
            }
        }

        return redirect('/referral');
    }
}
