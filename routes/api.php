<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Routes related to authentication and token // TODO group right and auth not all
Route::group(['middleware' => 'api',    'prefix' => 'auth'], function ($router) {

    Route::get('/users', [UserController::class, 'index'])->name("get all users");

    Route::post('register', [AuthController::class, 'register'])->name("register");
    Route::post('login', [AuthController::class, 'login'])->name("login");
    Route::post('logout', [AuthController::class, 'logout'])->name("logout");
    Route::post('update', [AuthController::class, 'update'])->name("update");
    Route::post('upgrade', [AuthController::class, 'upgrade'])->name("upgrade");
    // Route::post('refresh', [AuthController::class, 'refresh'])->name("refresh");
});

// Routes related to Reviews, create, get all inactive, activate or delete //TODO authorization
// Route::group(['middleware' => 'api',    'prefix' => 'reviews'], function ($router) {
Route::get('/', [ReviewController::class, 'index'])->name("get-inactive-reviews");
Route::post('/create', [ReviewController::class, 'create'])->name("create-review");
Route::post('/activate', [ReviewController::class, 'activate'])->name("activate-review");
// });



// Routes related to signed in user //TODO authorize user middleware

// Routes related to admin //TODO authorize admin middleware

// TODO routes of items, prefix with items
// Items, create, , upgrade, routes  
Route::get('/', [ItemController::class, 'index'])->name("get all items");
// TODO include get all active reviews witin this
Route::get('/{id}', [ItemController::class, 'show'])->name("get a specific restaurant");
Route::post('/restaurants/create', [ItemController::class, 'create'])->name("create a restaurant");
