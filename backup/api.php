<?php
use App\Http\Controllers\BotQuestionController;
use App\Http\Controllers\LeadController;

Route::get('/bot/questions', [BotQuestionController::class, 'index']);
Route::post('/bot/lead', [LeadController::class, 'store']);
Route::get('/bot/org/{id}', function ($id) {
    return \App\Models\Organization::findOrFail($id);
});
Route::post('/bot/decrypt-org', [BotSecurityController::class, 'decryptOrg']);

