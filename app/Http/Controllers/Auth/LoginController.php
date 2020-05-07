<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewLogCreated;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $testeroor = $this->validate($request, [
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        if (auth()->user()) {
            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();
        }

        $the_user = User::where('user_name', '=', request('email'))->first();
        if ($the_user) {
            $request['email'] = $the_user->email;
        }

        if (auth()->attempt(['email' => $request['email'], 'password' => request('password')])) {
            event(new NewLogCreated(' تسجيل الدخول', Auth::user()->full_name, 1, 0, null));

            config(['session.lifetime' => 1]);
            return $this->sendLoginResponse($request);
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        event(new NewLogCreated(' تسجيل الخروج', Auth::user()->full_name, 2, 0, null));
        auth()->logout();
        return redirect('/login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


}
