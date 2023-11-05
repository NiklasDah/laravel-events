<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::view('events', 'events')->name('events');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('event/{event}', App\Livewire\Events\Index::class)->name('event.index');
});

Route::get('scanner/{event}', App\Livewire\Events\Scanner::class)
    ->middleware(['auth', 'verified', 'organizer'])
    ->name('scanner');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


require __DIR__.'/auth.php';
