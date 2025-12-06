<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyQuestionController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\QuoteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Daily questions
    Route::post('/daily-questions', [DailyQuestionController::class, 'store'])
        ->name('daily.questions.store');
});

require __DIR__.'/auth.php';

// Journal
Route::get('/journal', function () {
    return view('journal.index');
})->name('journal.index');

// Chat
Route::view('/chat', 'chat.index')->name('chat.index');

// Check-in
Route::view('/checkin', 'checkin.start')->name('checkin.start');

// Dashboard
Route::get('/dashboard', [QuoteController::class, 'dashboard'])->name('dashboard');

// Save a quotes
Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');

// Heart toggle
Route::post('/quotes/toggle', [QuoteController::class, 'toggle'])->name('quotes.toggle');

// Pin/unpin
Route::post('/quotes/pin/{quote}', [QuoteController::class, 'pin'])->name('quotes.pin');

// Journal
Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
Route::post('/journal/redirect', [QuoteController::class, 'redirectToJournal'])->name('journal.redirect');
Route::get('/journal/create', [JournalController::class, 'create'])->name('journal.create');
Route::post('/journal/store', [JournalController::class, 'store'])->name('journal.store');
Route::delete('/journal/{id}/archive', [JournalController::class, 'archive'])->name('journal.archive');
Route::post('/journal/{id}/share', [JournalController::class, 'share'])->name('journal.share');
Route::post('/journal/{id}/restore', [JournalController::class, 'restore'])->name('journal.restore');
Route::get('/journal/archived', [JournalController::class, 'archived'])->name('journal.archived');