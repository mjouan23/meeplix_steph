<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Mail\NewUserPasswordMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Pas de middleware 'guest' ici : l'accès est contrôlé par le middleware 'role' sur les routes
        $this->middleware(['auth', 'role:admin,moderator']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255']
        ]);
    }

    /**
     * Override register to create the user without logging them in.
     * This implements "option 2": admin creates user, email sent, stay logged as admin.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // create the user (create() returns the User instance)
        $user = $this->create($request->all());

        event(new Registered($user));

        return redirect()->back()->with('success', 'Utilisateur créé et email envoyé.');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $password = Str::random(10);
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => User::ROLE_SUBSCRIBER, // Par défaut, le rôle est 'subscriber'
            'password' => Hash::make($password),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'must_change_password' => true
        ]);

        // Envoi de l’email avec $password
        Mail::to($user->email)->send(new NewUserPasswordMail($user, $password));
        return redirect()->back()->with('success', 'Utilisateur créé et email envoyé.');
    }

    /**
     * Affiche le formulaire de création d'utilisateur (override pour ne pas rediriger si connecté)
     */
    public function showRegistrationForm()
    {
        // renvoie la vue d'inscription / création ; les vérifs d'accès sont faites par les middlewares de route
        return view('auth.register');
    }
}
