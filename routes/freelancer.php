<?php

use App\Http\Controllers\Freelancer\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'freelancer',
    'as' => 'freelancer.',
    'middleware' => ['auth:web'],
], function() {

    Route::get('profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
        
    Route::put('profile', [ProfileController::class, 'update']);

});