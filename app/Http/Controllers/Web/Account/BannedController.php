<?php
 
namespace App\Http\Controllers\Web\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BanController;

class BannedController extends Controller
{
    public function index()
    {
        $ban = Auth::user()->ban();

        if (!Auth::user()->isBanned())
            abort(404);

        $length = array_search($ban->length, BanController::BAN_LENGTHS);
        $category = array_search($ban->category, BanController::BAN_CATEGORIES);
        $canReactivate = strtotime($ban->banned_until) < time();

        if ($length == 'Close Account')
            $length = 'Account Deleted';

        return view('web.account.banned')->with([
            'ban' => $ban,
            'length' => $length,
            'category' => $category,
            'canReactivate' => $canReactivate
        ]);
    }

    public function reactivate(Request $request)
    {
        $ban = Auth::user()->ban();

        if (!Auth::user()->isBanned())
            abort(404);

        $canReactivate = strtotime($ban->banned_until) < time();

        if (!$request->has('accept'))
            return back()->withErrors(['You must agree to the Terms of Service to continue playing.']);
        else if (!$canReactivate || $ban->length == 'closed')
            return back()->withErrors(['You can not reactivate your account yet.']);

        $ban->active = false;
        $ban->save();

        return redirect()->route('home.dashboard')->with('success_message', 'Account has been reactivated!');
    }
}
