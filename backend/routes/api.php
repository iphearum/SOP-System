<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('templates', TemplateController::class);
    Route::apiResource('documents', DocumentController::class);
    Route::post('documents/{document}/submit', [DocumentController::class, 'submit']);
    Route::post('documents/{document}/publish', [DocumentController::class, 'publish']);

    Route::get('documents/{document}/approvals', [ApprovalController::class, 'index']);
    Route::post('documents/{document}/approvals', [ApprovalController::class, 'store']);
});
