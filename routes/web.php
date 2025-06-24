<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\AuthorsTable;
use App\Livewire\PostsTable;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware('auth')->group(function () {
    Route::get('/authors', AuthorsTable::class)->name('authors.index');
});


Route::middleware('auth')->group(function () {
    Route::get('/authors', AuthorsTable::class)->name('authors.index');
    Route::get('/authors/{author}/posts', PostsTable::class)->name('authors.posts');
});
require __DIR__.'/auth.php';
