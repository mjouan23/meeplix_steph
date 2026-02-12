<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardgameController;
use App\Http\Controllers\Dashboard\UserController as DashboardUserController;
use \App\Http\Controllers\Dashboard\BoardgameController as DashboardBoardgameController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\PartyController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/boardgames');

Route::get('/boardgames', [BoardgameController::class, 'index'])->name('boardgames.index');

Auth::routes(['verify' => true]);
// Importe les routes suivantes pour l'authentification
// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

Route::get('/boardgames', [App\Http\Controllers\HomeController::class, 'index'])->name('boardgames');

// Routes des jeux de société accessibles aux utilisateurs authentifiés
Route::middleware(['auth', 'force.password.change'])->group(function () {
    Route::resource('boardgames', BoardgameController::class)->only(['index', 'show']);
    Route::resource('parties', PartyController::class);
});

// Création de jeux : uniquement admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/dashboard/boardgames/create', [DashboardBoardgameController::class, 'create'])->name('dashboard.boardgames.create');
    Route::post('/dashboard/boardgames', [DashboardBoardgameController::class, 'store'])->name('dashboard.boardgames.store');

    Route::delete('/dashboard/boardgames/{boardgame}', [DashboardBoardgameController::class, 'destroy'])->name('dashboard.boardgames.destroy');

    // Liste des utilisateurs
    Route::get('/dashboard/users', [DashboardUserController::class, 'index'])->name('dashboard.users.index');

    // Création d'utilisateur via les méthodes du RegisterController (protégé par same middleware)
    Route::get('/dashboard/users/create', [RegisterController::class, 'showRegistrationForm'])->name('dashboard.users.create');
    Route::post('/dashboard/users', [RegisterController::class, 'register'])->name('dashboard.users.store');
});

// Dashboard et Administration des jeux accessibles aux admin et modérateurs
Route::middleware(['auth', 'role:admin,moderator'])->group(function () {

    Route::get('/dashboard/boardgames', [DashboardBoardgameController::class, 'index'])->name('dashboard.boardgames.index');
    Route::get('/dashboard/boardgames/{boardgame}', [DashboardBoardgameController::class, 'show'])->name('dashboard.boardgames.show');

    Route::get('/dashboard/boardgames/{boardgame}/edit', [DashboardBoardgameController::class, 'edit'])->name('dashboard.boardgames.edit');
    Route::put('/dashboard/boardgames/{boardgame}', [DashboardBoardgameController::class, 'update'])->name('dashboard.boardgames.update');

    Route::post('/dashboard/boardgames/{boardgame}/upload-file', [DashboardBoardgameController::class, 'uploadFile'])->name('dashboard.boardgames.uploadFile');
    Route::delete('/dashboard/boardgames/files/{file}', [DashboardBoardgameController::class, 'destroyFile'])->name('dashboard.boardgames.files.destroy');
});

// routes pour le changement de mot de passe
Route::get('password/change', [PasswordChangeController::class, 'show'])
    ->name('password.change')
    ->middleware('auth');

Route::post('password/change', [PasswordChangeController::class, 'update'])
    ->name('password.change.update')
    ->middleware('auth');





