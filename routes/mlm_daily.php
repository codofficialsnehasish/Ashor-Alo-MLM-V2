<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CornJobs;
use App\Http\Controllers\CornJobsTest;

Route::get('roi-bonus',[CornJobs::class,'roi_bonus']);
Route::get('process-direct-bonus',[CornJobs::class,'process_direct_bonus']);
Route::get('level-bonus',[CornJobs::class,'level_bonus']);
Route::get('payout',[CornJobs::class,'payout']);

Route::get('/test-jobs', [CornJobsTest::class, 'testJobsForDateRange']);
Route::get('/generate-dates', [CornJobsTest::class, 'generate_dates']);
Route::get('/level-bonus-data-set', [CornJobsTest::class, 'level_bonus_data_set']);
