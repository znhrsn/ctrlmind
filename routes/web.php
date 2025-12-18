<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyQuestionController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\ConsultantDashboardController;
use App\Http\Controllers\ConsultantNotificationController;
use App\Notifications\NewClientAssigned;
use App\Http\Controllers\SuggestionController;

// The name must match 'suggestions.store' exactly
Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestions.store');

Route::get('/', function () {
    return view('welcome');
});

// ✅ User dashboard
Route::get('/dashboard', [QuoteController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Daily questions
    Route::post('/daily-questions', [DailyQuestionController::class, 'store'])->name('daily.questions.store');

    // Journal// Show reflection form
    Route::get('/quotes/{quote}/share-to-journal', [\App\Http\Controllers\QuoteController::class, 'showShareForm'])
        ->name('quotes.showShareForm');

    Route::get('/journals', [JournalController::class, 'index'])
        ->name('journals.index');


    // Handle saving reflection
    Route::post('/quotes/share-to-journal', [\App\Http\Controllers\QuoteController::class, 'shareToJournal'])
        ->name('quotes.shareToJournal');

    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::get('/journal/create', [JournalController::class, 'create'])->name('journal.create');
    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');
    Route::get('/journal/{id}/edit', [JournalController::class, 'edit'])->name('journal.edit');
    Route::put('/journal/{id}', [JournalController::class, 'update'])->name('journal.update');
    Route::post('/journal/{id}/restore', [JournalController::class, 'restore'])->name('journal.restore');
    Route::post('/journal/{id}/share', [JournalController::class, 'share'])->name('journal.share');
    Route::get('/journal/archived', [JournalController::class, 'showArchived'])->name('journal.archived');
    Route::get('/consultant/shared-journals', [ConsultantController::class, 'sharedJournals'])->name('consultant.shared-journals');
    Route::post('/journal/{id}/archive', [JournalController::class, 'archiveEntry'])
    ->name('journal.archiveEntry');
    // routes/web.php
    Route::middleware(['auth'])->group(function () {
        Route::get('/consultants/shared-journals', [\App\Http\Controllers\ConsultantController::class, 'sharedJournals'])
            ->name('consultants.shared_journals');
    });
    Route::post('/journal/{id}/share', [\App\Http\Controllers\JournalController::class, 'share'])
    ->middleware('auth')
    ->name('journal.share');
    // Change 'consultant.notifications.index' to 'consultants.notifications.index'
    Route::get('/consultant/notifications', [ConsultantNotificationController::class, 'index'])
        ->name('consultants.notifications.index');


    // Quotes
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
    Route::post('/quotes/toggle', [QuoteController::class, 'toggle'])->name('quotes.toggle');
    Route::post('/quotes/pin', [QuoteController::class, 'pin'])->name('quotes.pin');
    Route::post('/journal/redirect', [QuoteController::class, 'redirectToJournal'])->name('journal.redirect');

    // Mood Tracking
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');

    // Resources
    Route::resource('resources', ResourceController::class);
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/{resource}', [ResourceController::class, 'show'])
        ->name('resources.show');

    // Consultant Search
    Route::get('/consultant/search', [ConsultantController::class, 'search'])
    ->name('consultant.search');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/consultant/chat/{user}', [ConsultantController::class, 'chat'])->name('consultant.chat');
    Route::post('/consultant/chat/{user}', [ConsultantController::class, 'reply'])->name('consultant.chat.reply');

    // ✅ Consultant dashboard
    Route::get('/consultant/dashboard', [ConsultantDashboardController::class, 'index'])->name('consultant.dashboard');

    // ✅ Consultant notifications
    Route::get('/consultant/notifications', [ConsultantNotificationController::class, 'index'])
        ->name('consultant.notifications.index');

    // Authentication routes
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Check-in
    Route::get('/checkin/start', [CheckinController::class, 'start'])->name('checkin.start');

    Route::get('/checkin', [CheckinController::class, 'index'])
    ->name('checkin.index');

    Route::post('/checkin', [CheckinController::class, 'store']) ->middleware(['auth']) ->name('checkin.store');

    Route::get('/checkins', [MoodController::class, 'index'])->name('checkins.index');
    Route::post('/checkins', [MoodController::class, 'store'])->name('checkins.store');
    Route::post('/checkin', [CheckinController::class, 'store'])->name('checkin.store');
    
});

require __DIR__.'/auth.php';