<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamRecordController;

Route::prefix('records')->group(function () {
    Route::get('/', [StreamRecordController::class, 'index']); // Get all records
    Route::post('/', [StreamRecordController::class, 'store']); // Create a new record
    Route::get('/{id}', [StreamRecordController::class, 'show']); // Get a single record
    Route::put('/{id}', [StreamRecordController::class, 'update']); // Update a record
    Route::delete('/{id}', [StreamRecordController::class, 'destroy']); // Delete a record
});