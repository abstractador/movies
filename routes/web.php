<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\GenresController;
use App\Http\Controllers\Admin\CastController;

Route::get('/', function () {
    return view('agent');
});

Route::prefix('admin')->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    
    Route::middleware(['auth', 'admin'])->group(function () {    
        
        Route::get('/movies/data', [MovieController::class, 'datatable'])->name('admin.movies.data');
        
        Route::get('/movies/{movie}/view', [MovieController::class, 'view'])->name('admin.movies.view');
        
        Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('admin.movies.destroy');

        Route::get('/genres', [GenresController::class, 'index'])->name('admin.genres.index');

        Route::get('/genres/data', [GenresController::class, 'datatable'])->name('admin.genres.data');

        Route::delete('/genres/{genre}', [GenresController::class, 'destroy'])->name('admin.genres.destroy');

        Route::get('/cast', [CastController::class, 'index'])->name('admin.cast.index');

        Route::get('/cast/data', [CastController::class, 'datatable'])->name('admin.cast.data');

        Route::get('/cast/{person}/view', [CastController::class, 'view'])->name('admin.cast.view');

        Route::delete('/cast/{person}', [CastController::class, 'destroy'])->name('admin.cast.destroy');
        
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        
    });
});

?>
