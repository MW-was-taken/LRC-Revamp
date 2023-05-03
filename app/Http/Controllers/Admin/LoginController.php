<?php
 
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\StaffUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $returnLocation = $request->returnLocation;

        return view('admin.login')->with([
            'returnLocation' => $returnLocation
        ]);
    }

    public function authenticate(Request $request)
    {
        $user = User::where('username', '=', $request->username);
        $code = config('site.admin_panel_code') ?? null;

        if ($user->exists() && $user->first()->isStaff() && $request->code == $code) {
            $user = $user->first();

            if (password_verify($request->password, $user->staff('password'))) {
                session()->put('staff_user_id', $user->staff('id'));
                session()->put('staff_user_site_id', $user->id);
                session()->put('staff_user_password', $user->staff('password'));
                session()->save();

                $user = StaffUser::where('user_id', '=', $user->id)->first();
                $user->ping = time();
                $user->save();

                if ($request->has('return_location'))
                    return redirect($request->return_location);

                return redirect()->route('admin.index');
            }
        }

        return back()->withErrors(['The credentials you have provided are wrong!']);
    }

    public function logout()
    {
        session()->forget('staff_user_id');
        session()->forget('staff_user_site_id');
        session()->forget('staff_user_password');

        return redirect()->route('admin.login.index');
    }
}
