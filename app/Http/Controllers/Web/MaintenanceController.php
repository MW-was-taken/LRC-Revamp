<?php
 
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaintenanceController extends Controller
{
    public function index()
    {
        if (session()->has('maintenance_password'))
            return redirect()->route('home.index');

        return view('web.maintenance.index');
    }

    public function authenticate(Request $request)
    {
        $maintenancePasswords = config('site.maintenance_passwords');

        if (session()->has('maintenance_password'))
            return back()->withErrors(['Already authenticated.']);

        if (!$request->has('password') || empty(trim($request->password)))
            return back()->withErrors(['Please provide a password.']);

        if (!in_array($request->password, $maintenancePasswords))
            return back()->withErrors(['Invalid password.']);

        session()->put('maintenance_password', $request->password);
        session()->save();

        return redirect()->route('home.index');
    }

    public function exit()
    {
        session()->forget('maintenance_password');

        return redirect()->route('maintenance.index');
    }
}
