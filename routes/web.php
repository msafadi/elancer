<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:admin'])->name('dashboard');

// require __DIR__.'/auth.php';

// Route::group([
//     'prefix' => 'admin',
//     'as' => 'admin.',
// ], function() {
//     require __DIR__.'/auth.php';
// });

require __DIR__.'/dashboard.php';

require __DIR__.'/freelancer.php';

require __DIR__.'/client.php';
