<?php
 
namespace App\Http\Controllers\Web\Account;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function index()
    {
        $users = User::where('referrer_id', '=', Auth::user()->id)->paginate(5);

        return view('web.account.invite')->with([
            'users' => $users
        ]);
    }
}
