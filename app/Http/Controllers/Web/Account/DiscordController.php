<?php
 
namespace App\Http\Controllers\Web\Account;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscordController extends Controller
{
    public function index()
    {
        return view('web.account.discord');
    }

    public function generate()
    {
        $user = Auth::user();

        if (!empty(Auth::user()->discord_id)) {
            $user->discord_code = null;
            $user->discord_id = null;
            $user->save();

            return back()->with('success_message', 'Discord account has been unlinked!');
        }

        if (!empty(Auth::user()->discord_code))
            return back()->withErrors(['You have already generated a code!']);

        $user->discord_code = Str::random(40);
        $user->save();

        return back()->with('success_message', 'Discord code has been generated!');
    }
}
