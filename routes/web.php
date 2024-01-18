<?php



use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\AuthController;

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

// Route::get('/', function () {
//     return view('layout');
// });

// Route::get('/', function () {
//     return view('admin.login');
// });
// Route::prefix('admin')->group(function () {

//     Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('admin.login');
// });

Route::prefix('admin')->group(function () {
    Route::match(['GET', 'POST'], 'login', [AuthController::class, 'login'])->name('admin_login');

    // Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::group(['middleware' => ['admin']], function () {

        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('admin_dashboard');
        Route::get('logout', [AuthController::class, 'logout'])->name('admin_logout');
    });

});
