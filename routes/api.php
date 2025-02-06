<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

Route::post('/chatbot/store', [ChatbotController::class, 'store']);

