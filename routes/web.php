<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\GenresController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/agent', function () {
    return view('agent');
});

Route::prefix('admin')->group(function () {
    
    Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('admin.login');
    
    Route::post('/login', [AuthController::class, 'login'])
    ->name('admin.login.submit');
    
    Route::middleware(['auth', 'admin'])->group(function () {
        
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/movies/data', [MovieController::class, 'datatable'])->name('admin.movies.data');
        
        Route::get('/movies/{movie}/view', [MovieController::class, 'view'])->name('admin.movies.view');
        
        Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('admin.movies.destroy');

        Route::get('/genres', [GenresController::class, 'index'])->name('admin.genres.index');

        Route::get('/genres/data', [GenresController::class, 'datatable'])->name('admin.genres.data');

        Route::delete('/genres/{genre}', [GenresController::class, 'destroy'])->name('admin.genres.destroy');
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        
    });
});

?>
