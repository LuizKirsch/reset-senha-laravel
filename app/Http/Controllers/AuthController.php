<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function login_action(Request $request){
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        if (Auth::attempt($validator)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['message' => 'Credenciais inválidas.'])->withInput();
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login');
    }
    // exibe o formulário de recuperação de senha
    public function forgot_pass()
    {
        return view('auth.forgot-password');
    }

    // envia o link de recuperação de senha
    public function send_reset_link(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            // ? back()->with(['status' => __($status)])
            ? back()->with(['status' => 'Enviamos o e-mail para redefinição!'])
            // : back()->withErrors(['email' => __($status)]);
            : back()->withErrors(['email' => 'Aconteceu algum erro!']);
    }

    // exibe o formulário de redefinição de senha
    public function show_reset_form(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // redefine a senha do usuário
    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}