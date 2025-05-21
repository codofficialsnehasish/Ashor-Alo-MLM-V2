<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CornJobs;

Route::get('roi-bonus',[CornJobs::class,'roi_bonus']);
Route::get('process-direct-bonus',[CornJobs::class,'process_direct_bonus']);
Route::get('level-bonus',[CornJobs::class,'level_bonus']);
Route::get('payout',[CornJobs::class,'payout']);