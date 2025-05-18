<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::get('/', function () {
    return redirect()->route('main');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/events/my', [EventController::class, 'myEvents'])->name('events.my');
    Route::get('/events/participated', [EventController::class, 'participatedEvents'])->name('events.participated');

    Route::get('/main', MainController::class)->name('main');
    Route::resource('events', EventController::class);
    Route::resource('events.reports', ReportController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/reject', [ReportController::class, 'reject'])->name('reports.reject');
    Route::post('/reports/block', [ReportController::class, 'block'])->name('reports.block');
    Route::resource('events.participants', ParticipantController::class);
    Route::resource('events.reviews', ReviewController::class);
    Route::resource('feedbacks', FeedbackController::class);
    Route::patch('/feedbacks/{feedback}/resolve', [FeedbackController::class, 'resolve'])->name('feedbacks.resolve');
});
