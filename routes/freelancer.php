<?php

use App\Http\Controllers\Freelancer\ProfileController;
use App\Http\Controllers\Freelancer\ProposalsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'freelancer',
    'as' => 'freelancer.',
    'middleware' => ['auth:web'],
], function() {

    Route::get('proposals', [ProposalsController::class, 'index'])
        ->name('proposals.index');
    Route::get('proposals/{project}/create', [ProposalsController::class, 'create'])
        ->name('proposals.create');
    Route::post('proposals/{project}/create', [ProposalsController::class, 'store'])
        ->name('proposals.store');

    Route::get('profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
        
    Route::put('profile', [ProfileController::class, 'update']);

});