<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranscriptController;

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

Route::get('/transcript', [TranscriptController::class, 'index'])->name('transcript.index');
Route::post('/transcript/upload', [TranscriptController::class, 'upload'])->name('transcript.upload');
Route::get('/transcript/edit/{id}', [TranscriptController::class, 'edit'])->name('transcript.edit');
Route::put('/transcript/update/{id}', [TranscriptController::class, 'update'])->name('transcript.update');
Route::delete('/transcript/destroy/{id}', [TranscriptController::class, 'destroy'])->name('transcript.destroy');
