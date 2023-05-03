<?php
 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyAccount
{
    public const VERIFY_ROUTES = [
        'forum.new',
        'forum.create'
    ];

    public const API_VERIFY_URLS = [
        //
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
        $url = str_replace("{$request->root()}/api/", '', $request->url());

        if (config('app.env') == 'production' && Auth::check() && !Auth::user()->hasVerifiedEmail() && (in_array($url, $this::API_VERIFY_URLS) || in_array($route, $this::VERIFY_ROUTES)))
            return redirect()->route('account.verify.index')->withErrors(['You must verify your email first to do this.']);

        return $next($request);
    }
}
