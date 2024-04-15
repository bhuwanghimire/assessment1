<?php

use App\Http\Controllers\Backend\JsonUploaderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuth\SocialLoginController;
use App\Models\JsonUploader;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    $jsons = JsonUploader::orderBy('id','desc')->get();
    return view('dashboard',compact('jsons'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//  Route to redirect user to the authentication page of a specified social provider.
// The `{provider}` parameter will dynamically match the provider's name (e.g., 'google', 'facebook','github').
Route::get('/login/{provider}',[SocialLoginController::class,'redirectProvider'])->name('provider_redirect');

// Route to handle the callback from the social provider after user authentication.
Route::get('{provider}/callback',[SocialLoginController::class,'handleCallBack'])->name('handle_callback');


Route::middleware('auth')->group(function () {

//ROute to upload the json file to storage folder
Route::post('store',[JsonUploaderController::class,'Store'])->name('json.store');

//Route to download the json file to excel ...
Route::get('download/{id}',[JsonUploaderController::class,'Download'])->name('json.download');
});
