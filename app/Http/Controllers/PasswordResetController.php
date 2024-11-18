<?php

namespace App\Http\Controllers;

use App\Models\Doador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class PasswordResetController extends Controller
{

    public function showResetForm(Request $request)
{
    $token = $request->token;

    return view('emails.reset_password', ['token' => $token]);
}

    // Método para solicitar a redefinição de senha
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $doador = Doador::where('emailDoador', $request->email)->first();
    
        if (!$doador) {
            return response()->json(['message' => 'E-mail não encontrado.'], 404);
        }
    
        // Gerar o token
        $token = Str::random(64);
    
        // Atualizar o token no banco
        $doador->reset_token = $token;
        $doador->save();
    
        // Enviar o e-mail
        Mail::to($doador->emailDoador)->send(new PasswordResetMail($token));
            
        return back()->with('success', 'Link de redefinição enviado para o e-mail.');
        }

    // Método para redefinir a senha
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
    
        $doador = Doador::where('reset_token', $request->token)->first();
    
        if (!$doador) {
            return redirect()->back()->withErrors(['token' => 'Token inválido ou expirado.']);
        }
    
        // Atualizar a senha
        $doador->senhaDoador = $request->password; // Armazenar a senha criptografada
        $doador->reset_token = null; // Remover o token após o uso
        $doador->save();
    
        return redirect('/logindoador')->with('success', 'Senha redefinida com sucesso.');
    }
    
}
