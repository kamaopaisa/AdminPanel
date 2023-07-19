<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationSendController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => true]);

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::middleware([RoleMiddleware::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('change_password');
    Route::post('/admin/change_password', [AdminController::class, 'change_password']);
    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
    Route::get('/notifications', [NotificationSendController::class, 'index'])->name('notifications');
    Route::get('/version', [AdminController::class, 'version'])->name('version');
    Route::post('/addVersion', [AdminController::class, 'addVersion'])->name('addVersion');

    Route::post('/version/{id}/update-status', [AdminController::class,'updateVersionStatus'])->name('versions.updateStatus');

    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});




// Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');
