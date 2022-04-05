<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\InscriptionsController;
use App\Http\Controllers\InscriptionsDetailsController;

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
    return view('welcome');
});

// Route::get('/students', function () {
//     return StudentsController::index();
// });

Route::apiResources([
    'students' => StudentsController::class,
    'subjects' => SubjectsController::class,
    'inscriptions' => InscriptionsController::class,
    'inscriptions-details' => InscriptionsDetailsController::class,
]);