<?php

namespace App\Http\Middleware;

use App\Models\Complain;
use App\Models\ManagerBoarding;
use App\Models\OwnerBoarding;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplainAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tenantId = Complain::find($request->id)->user_id;
        $boardingId = Complain::find($request->id)->boarding_id;
        $ownerId = OwnerBoarding::where('boarding_id', $boardingId)->first()->user_id;
        $managerId = ManagerBoarding::where('boarding_id', $boardingId)->first()->user_id ?? -1;
        if (Auth::user()->id !== $tenantId && Auth::user()->id !== $ownerId && (Auth::user()->id !== $managerId && $managerId == -1)) {
            abort(404, 'Not Found');
        }
        return $next($request);
    }
}
