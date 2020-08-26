<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use App\Admin;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 3;
    protected $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('altar.auth.login');
    }

    public function username()
    {
        return 'email';
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ]);

        if( $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if( auth()->guard('admin')->attempt(
        	 	$request->only( $this->username() , 'password'), 
        	 	$request->filled('remember') 
        	 ) 
           ) {
            
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);
            
            return $request->wantsJson()
                    ? new Response('', 204)
                    : redirect()->route('admin.home');
        } 
        
        $this->incrementLoginAttempts($request);

        return redirect()
            ->back()
            ->withInput()
            ->withErrors([ $this->username() =>"Make sure the ".strtolower($this->username())." or password is correct!"]);
    }
    
    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        session()->flush();
        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->route('admin.login');
    }
}
