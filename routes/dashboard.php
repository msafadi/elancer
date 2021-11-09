<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/dashboard',
    'namespace' => 'Dashboard',
    'middleware' => ['auth:admin,web'],
], function() {

    Route::prefix('/categories')
        ->as('categories.')
        ->group(function() {
            Route::get('/', [CategoriesController::class, 'index'])
                ->name('index');
            Route::get('/trash', [CategoriesController::class, 'trash'])
                ->name('trash');
            Route::get('/create', [CategoriesController::class, 'create'])
                ->name('create');
            Route::get('/{category}', [CategoriesController::class, 'show'])
                ->name('show');
            Route::post('/', [CategoriesController::class, 'store'])
                ->name('store');
            Route::get('/{category}/edit', [CategoriesController::class, 'edit'])
                ->name('edit');
            Route::put('/{category}', [CategoriesController::class, 'update'])
                ->name('update');
            Route::delete('/{category}', [CategoriesController::class, 'destroy'])
                ->name('destroy');

            Route::put('/trash/{category}/restore', [CategoriesController::class, 'restore'])
                ->name('restore');
            Route::delete('/trash/{category}', [CategoriesController::class, 'forceDelete'])
                ->name('forceDelete');
        });


        Route::get('profile', function() {
            return 'Secret Profile';
        })->middleware('password.confirm');
});