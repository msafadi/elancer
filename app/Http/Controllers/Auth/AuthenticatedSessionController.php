<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{

    protected $guard = 'web';

    public function __construct(Request $request)
    {
        if ($request->is('admin/*')) {
            $this->guard = 'admin';
        }
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login', [
            'routePrefix' => $this->guard == 'admin'? 'admin.' : '',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate($this->guard);

        // Auth::attempt([
        //     'email' => $request->post('email'),
        //     'password' => $request->post('password'),
        // ]);

        // $user = User::where('email', '=', $request->post('email'))
        //             ->orWhere('mobile', '=', $request->post('email'))
        //             ->orWhere('username', '=', $request->post('email'))
        //     //->where('password', '=', Hash::make($request->post('password')))
        //     ->first();

        // if (!$user || !Hash::check($request->post('password'), $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => 'Invalid credentials!',
        //     ]);
        // }

        // Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(
            $this->guard == 'admin'
            ? '/dashboard'
            : RouteServiceProvider::HOME
        );
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // $request->user(); // == Auth::user();

        Auth::guard($this->guard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
