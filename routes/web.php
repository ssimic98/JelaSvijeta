<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;

Route::apiResource('/meals',MealController::class)->only(['index']);