<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role']);
    }

    /**
     * Affiche la liste des utilisateurs.
     */
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('dashboard.users.index', compact('users'));
    }
}