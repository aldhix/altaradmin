<?php

namespace Aldhix\Altaradmin\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Aldhix\Altaradmin\Models\Admin;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 10;
    protected $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function loginForm()
    {
        return view('admin::auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        if (auth()->guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return redirect()->route('admin.home');
        } else {
            $this->incrementLoginAttempts($request);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['email'=>"Incorrect Email and Password login details!"]);
        }
    }
    
    public function logout()
    {
        auth()->guard('admin')->logout();
        session()->flush();
        return redirect()->route('admin.login');
    }

}
