<?php
 
namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('web.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = User::where('username', '=', $request->username)->first();

            $login = new UserLogin;
            $login->user_id = $user->id;
            $login->ip = $request->ip();
            $login->save();

            return redirect()->route('home.dashboard')->with('success_message', 'You have successfully logged in!');
        }

        return back()->withErrors(['The credentials you have provided are wrong!']);
    }

    public function logout()
    {
        Auth::logout();

        return back();
    }
}
