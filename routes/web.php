<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CompanyProfileController::class, 'index'])->name('home');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
