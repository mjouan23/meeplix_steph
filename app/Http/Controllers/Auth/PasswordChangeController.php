<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    /**
     * Affiche le formulaire de changement de mot de passe.
     */
    public function show()
    {
        return view('auth.passwords.change');
    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     */
    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('boardgames.index')->with('success', 'Mot de passe changé avec succès.');
    }
}