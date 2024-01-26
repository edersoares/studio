<?php

declare(strict_types=1);

use Dex\Laravel\Studio\Http\Controllers\StudioController;
use Illuminate\Support\Facades\Route;

Route::get('studio', StudioController::class);
