<?php

use App\Http\Controllers\Api\AuthTokensController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Middleware\CheckApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    // GET /api/projects -> index
    // POST /api/projects -> store
    // GET  /api/projects/{project} -> show
    // PUT|PATCH  /api/projects/{project} -> update
    // DELETE  /api/projects/{project} -> destroy
    Route::apiResource('projects', 'Api\ProjectsController');
    
    Route::get('auth/tokens', [AuthTokensController::class, 'index'])
        ->middleware('auth:sanctum');
    
    Route::post('auth/tokens', [AuthTokensController::class, 'store'])
        ->middleware('guest:sanctum');
    
    Route::delete('auth/tokens/{id}', [AuthTokensController::class, 'destroy'])
        ->middleware('auth:sanctum');
