<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/telegram/webhook', [CallbackController::class, 'handleWebhook']);