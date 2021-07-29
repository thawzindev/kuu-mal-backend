<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BanIpAddress;

class BanIpAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        $bannedIps = BanIpAddress::pluck('ip_address')->toArray();

        if (in_array(getIp(), $bannedIps)) {
            return response()->json(['message' => 'သင်လက်ရှိအသုံးမပြုနိုင်ပါ။'], 422);
        }
        return $next($request);
    }
}
