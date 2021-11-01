<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyDesignController;
use App\Http\Controllers\SurveyDesignStoreController;
use App\Http\Controllers\SurveyPreviewResponseController;
use App\Http\Controllers\SurveyQuestionUpdateController;
use App\Http\Controllers\Api\SurveyQuestionDeleteController;
use App\Http\Controllers\SurveyCloningController;
use App\Http\Controllers\SurveySendResponse;
use App\Http\Controllers\SurveySharingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::redirect('/dashboard', 'surveys')->name('dashboard');

    Route::prefix('surveys')->as('surveys.')->group(function () {
        Route::get('/', [SurveyController::class, 'index'])->name('index');
        Route::post('/', [SurveyController::class, 'store'])->name('store');
        Route::get('/create', [SurveyController::class, 'create'])->name('create');
        Route::get('/{survey}', [SurveyController::class, 'show'])->name('show');
        Route::get('/{survey}/edit', [SurveyController::class, 'edit'])->name('edit');
        Route::put('/{survey}', [SurveyController::class, 'update'])->name('update');
        Route::delete('/{survey}', [SurveyController::class, 'destroy'])->name('destroy');
        Route::get('/{survey}/desgin', SurveyDesignController::class)->name('design');
        Route::get('/{survey}/preview-response/{identifier?}', SurveyPreviewResponseController::class)->name('preview-result');
        Route::post('/{survey}/desgin', SurveyDesignStoreController::class);
        Route::post('/survey/clone', SurveyCloningController::class)->name('clone');

        Route::put(
            '/{survey}/design/{question}/update',
            SurveyQuestionUpdateController::class
        )->name('question.update');

        Route::delete(
            'survey/{survey}/question/{question}', 
            SurveyQuestionDeleteController::class
        )->name('question.delete');

    });

});

Route::get(
    '/ts/{survey:uuid}',
    SurveySharingController::class
)->name('survey.share');

Route::post(
    '/{survey}/sendResponse/{anonymous}',
    SurveySendResponse::class
)->name('surveys.sendResponse');
