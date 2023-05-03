<?php
 
namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FloodCheck
{
    public const FLOOD_ROUTES = [
        'account.inbox.create',
        'account.settings.update',
        'account.trades.process',
        'report.submit',
        'catalog.update',
        'creator_area.create',
        'catalog.purchase',
        'forum.create',
        'groups.update',
        'jobs.listings.apply'
    ];

    public const API_FLOOD_URLS = [
        'groups/wall-post',
        'groups/manage/payout'
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

        if (Auth::check() && $request->isMethod('post') && (in_array($url, $this::API_FLOOD_URLS) || in_array($route, $this::FLOOD_ROUTES))) {
            $seconds = strtotime(Auth::user()->flood) - time();
            $word = ($seconds == 1) ? 'second' : 'seconds';

            if (time() < strtotime(Auth::user()->flood)) {
                if ($route == 'account.trades.process') {
                    if ($request->action == 'send')
                        return response()->json(['error' => "You are trying to do things too quickly! Please wait {$seconds} {$word} before trying again."]);
                } else if ($route == 'jobs.listings.apply') {
                    return response(['errors' => ['name' => ["You are trying to do things too quickly! Please wait {$seconds} {$word} before trying again."]]]);
                } else if ($request->is('api/*')) {
                    return response()->json(['error' => "You are trying to do things too quickly! Please wait {$seconds} {$word} before trying again."]);
                } else {
                    return back()->withErrors(["You are trying to do things too quickly! Please wait {$seconds} {$word} before trying again."]);
                }
            }

            $user = Auth::user();
            $user->flood = Carbon::createFromTimestamp(time() + config('site.flood_time'))->toDateTimeString();
            $user->save();
        }

        return $next($request);
    }
}
