<?php
 
namespace App\Http\Middleware;

use Closure;
use App\Models\StaffUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequireStaff
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
        $route = $request->route()->getName();

        if (Str::startsWith($route, 'admin.')) {
            if (!session()->has('staff_user_id') || !session()->has('staff_user_site_id') || !session()->has('staff_user_password')) {
                if (!in_array($route, ['admin.login.index', 'admin.login.authenticate']))
                    return redirect()->route('admin.login.index', ['returnLocation' => $request->url()]);
            } else {
                $user = StaffUser::where([
                    ['id', '=', session('staff_user_id')],
                    ['password', '=', session('staff_user_password')]
                ]);

                if (!$user->exists() || ($user->first()->ping + 600) < time()) {
                    session()->forget('staff_user_id');
                    session()->forget('staff_user_site_id');
                    session()->forget('staff_user_password');

                    return redirect()->route('admin.login.index', ['returnLocation' => $request->url()]);
                }

                $user = $user->first();

                if (($user->ping + 150) < time()) {
                    $user->ping = time();
                    $user->save();
                }
            }
        }

        return $next($request);
    }
}
