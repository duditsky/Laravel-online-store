<?php

namespace App\Http\Controllers;


use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\PasswordBroker;

class UserController extends Controller
{


  public function create()
  {
    return view('user.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'max:64'],
      'email' => ['required', 'email', 'max:64', 'unique:users'],
      'password' => ['required', 'min:6', 'confirmed']
    ]);

    User::create($validated);
    return redirect()->route('login')->with('success', 'User created successfully!');
  }

  public function loginForm()
  {
    return view('user.login-form');
  }

  public function loginAuth(Request $request)
  {
    $validated = $request->validate([
      'email' => ['required', 'email',],
      'password' => ['required', 'min:6']
    ]);
    if (Auth::attempt($validated)) {
      return redirect()->intended('/')->with('success', 'Login successful!');
    }
    return back()->withErrors('wrong email or password');
  }

  public function logOut()
  {
    Auth::logout();
    session()->flush();
    return redirect()->route('login');
  }

  public function showLinkRequestForm()
  {
    return view('user.passwords.email');
  }

  public function sendResetLinkEmail(Request $request)
  {
    $request->validate(['email' => 'required|email']);

    $status = Password::broker()->sendResetLink(
      $request->only('email')
    );

   return $status === Password::RESET_LINK_SENT
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
  }

  public function showResetForm(Request $request, $token = null)
  {
    return view('user.passwords.reset')->with(
      ['token' => $token, 'email' => $request->email]
    );
  }

  public function reset(Request $request)
  {
    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::broker()->reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function ($user, $password) {
        $user->forceFill([
          'password' => Hash::make($password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
      }
    );

    return $status === Password::PASSWORD_RESET
      ? redirect()->route('login')->with('success', __($status))
      : back()->withErrors(['email' => [__($status)]]);
  }

  public function orders(Request $request)
  {
    $user = $request->user();
    $orders = $user->orders;

    return view('user.orderPage', compact('orders'));
  }

  public function allOrders(Request $request)
  {
    $users = User::with('orders')->get();

    return view('user.allOrderPage', compact('users'));
  }

  public function changeStatus(Request $request, Order $order)
  {
    $request->validate([
      'status' => 'required|in:1,2,3,4',
    ]);

    $order->status = $request->status;
    $order->save();
    return redirect()->route('all.orders')->with('success', 'Status updated successfully!');
  }
}
