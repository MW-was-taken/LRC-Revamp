<?php
 
namespace App\Http\Middleware;

use Closure;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeChecker
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
        if (Auth::check()) {
            $user = Auth::user();
            $itemCount = Inventory::where('user_id', '=', $user->id)->count();

            // Administrator
            if ($user->isStaff() && !$user->ownsBadge(1))
                $user->giveBadge(1);
            else if (!$user->isStaff() && $user->ownsBadge(1))
                $user->removeBadge(1);

            // Forumer
            if ($user->forum_level >= 7 && !$user->ownsBadge(2))
                $user->giveBadge(2);
            else if ($user->forum_level < 7 && $user->ownsBadge(2))
                $user->removeBadge(2);

            // Friendship
            if ($user->friends()->count() >= 20 && !$user->ownsBadge(3))
                $user->giveBadge(3);

            // Rich
            if ($user->currency >= 500 && !$user->ownsBadge(5))
                $user->giveBadge(5);

            // Stockpiler
            if ($itemCount >= 50 && !$user->ownsBadge(6))
                $user->giveBadge(6);

            // Membership
            if ($user->hasMembership() && !$user->ownsBadge(9))
                $user->giveBadge(9);
            else if (!$user->hasMembership() && $user->ownsBadge(9))
                $user->removeBadge(9);
        }

        return $next($request);
    }
}
