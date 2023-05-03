<?php
 
namespace App\Http\Middleware;

use Closure;
use App\Models\IPBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfBanned
{
    public const ALLOWED_ROUTES = [
        'auth.logout',
        'account.banned.index',
        'account.banned.reactivate'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();
        $ipBanned = IPBan::where([
            ['ip', '=', $request->ip()],
            ['unbanner_id', '=', null]
        ])->exists();

        if ($ipBanned)
            return response('Database error.');

        if (Auth::check() && Auth::user()->isBanned() && !in_array($route, $this::ALLOWED_ROUTES))
            return redirect()->route('account.banned.index');

        return $next($request);
    }
}
