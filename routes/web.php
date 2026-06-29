<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rutas que ya vienen con Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta personalizada de la práctica 1
    Route::get('/perfil', function () {
        return view('perfil', [
            'user' => auth()->user()
        ]);
    })->name('perfil');
});

// Ruta a la que se redirige cuando se detecta celular
Route::get('/movil', function () {
    return 'Estás navegando desde un dispositivo móvil.';
})->name('movil');

// Ruta solo para administradores
Route::get('/admin/panel', function () {
    return 'Panel de administrador';
})->middleware(['auth', 'verificar.rol:admin'])->name('admin.panel');

// 3 rutas protegidas con SoloCelular
Route::middleware('solo.celular')->group(function () {
    Route::get('/pagina-uno', function () {
        return 'Página uno vista desde escritorio.';
    });

    Route::get('/pagina-dos', function () {
        return 'Página dos vista desde escritorio.';
    });

    Route::get('/pagina-tres', function () {
        return 'Página tres vista desde escritorio.';
    });
});

require __DIR__.'/auth.php';