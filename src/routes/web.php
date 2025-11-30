<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\WeightLogDetailController;
use App\Http\Controllers\TargetWeightController;

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
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('weight_logs');
    })->name('weight_logs');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', [RegistrationController::class, 'showStep1Form'])->name('register');

    Route::post('/register', [RegistrationController::class, 'postStep1'])->name('register.post');

    Route::get('/register/step2', [RegistrationController::class, 'showStep2Form'])->name('register.step2');

    Route::post('/register/step2', [RegistrationController::class, 'postStep2'])->name('register.step2.post');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    Route::get('/weight_logs/goal_setting', [TargetWeightController::class, 'showGoalSetting']);
    Route::post('/weight_logs/goal_setting/update', [TargetWeightController::class, 'updateTargetWeight']);

    Route::get('/weight_logs', [WeightLogController::class, 'index']);
    Route::get('/weight_logs/{weightLogId}', [WeightLogDetailController::class, 'show']);
    Route::post('/weight_logs/{weightLogId}/update',
    [WeightLogDetailController::class, 'update']);
    Route::post('/weight_logs/{weightLogId}/delete',
    [WeightLogDetailController::class, 'delete']);
});