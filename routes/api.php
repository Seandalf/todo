<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Models\Attachment;
use App\Models\Project;
use App\Models\Stage;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('projects/')->group(function () {
        //Projects
        Route::name('projects')->group(function () {
            Route::get('index', [ProjectController::class, 'index'])->can('viewAny', Project::class)->name('index');
            Route::put('store', [ProjectController::class, 'store'])->can('create', Project::class)->name('store');
            Route::patch('update/{project}', [ProjectController::class, 'update'])->can('update', 'project')->name('update');
            Route::delete('delete/{project}', [ProjectController::class, 'delete'])->can('delete', 'project')->name('delete');
        });

        //Stages
        Route::name('stages')->prefix('{project}/stages/')->group(function () {
            Route::get('index', [StageController::class, 'index'])->can('viewAny', Stage::class)->name('index');
            Route::put('store', [StageController::class, 'store'])->can('create', Stage::class)->name('store');
            Route::patch('update/{stage}', [StageController::class, 'update'])->can('update', 'stage')->name('update');
            Route::delete('delete/{stage}', [StageController::class, 'delete'])->can('delete', 'stage')->name('delete');
        });

        //Tasks
        Route::name('tasks')->prefix('{project}/tasks/')->group(function () {
            Route::get('index', [TaskController::class, 'index'])->can('viewAny', Task::class)->name('index');
            Route::put('store', [TaskController::class, 'store'])->can('create', Task::class)->name('store');
            Route::patch('update/{task}', [TaskController::class, 'update'])->can('update', 'task')->name('update');
            Route::delete('delete/{task}', [TaskController::class, 'delete'])->can('delete', 'task')->name('delete');
        });

        //Statuses
        Route::name('statuses')->prefix('{project}/statuses/')->group(function () {
            Route::get('index', [StatusController::class, 'index'])->can('viewAny', Status::class)->name('index');
            Route::put('store', [StatusController::class, 'store'])->can('create', Status::class)->name('store');
            Route::patch('update/{status}', [StatusController::class, 'update'])->can('update', 'status')->name('update');
            Route::delete('delete/{status}', [StatusController::class, 'delete'])->can('delete', 'status')->name('delete');
        });
    });
    
    //Attachments
    Route::name('attachments')->prefix('attachments/')->group(function () {
        Route::get('index', [Attachment::class, 'index'])->can('viewAny', Attachment::class)->name('index');
        Route::put('store', [Attachment::class, 'store'])->can('create', Attachment::class)->name('store');
        Route::patch('update/{attachment}', [Attachment::class, 'update'])->can('update', 'attachment')->name('update');
        Route::delete('delete/{attachment}', [Attachment::class, 'delete'])->can('delete', 'attachment')->name('delete');
    });
});

