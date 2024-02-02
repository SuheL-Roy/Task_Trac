<?php

use App\Http\Controllers\TaskTrackerController;
use App\Models\TaskTracker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $all_task = TaskTracker::orderBy('id','DESC')->get();
    return view('welcome',compact('all_task'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('task/')->middleware('auth')->name('TaskTracker.')->group(function () {
    Route::post('store', [TaskTrackerController::class, 'store'])->name('store');
    Route::get('edit', [TaskTrackerController::class, 'edit'])->name('edit');
    Route::post('update', [TaskTrackerController::class, 'update'])->name('update');
    Route::get('/delete', [TaskTrackerController::class, 'destroy'])->name('destroy');
});
