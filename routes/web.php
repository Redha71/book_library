<?php

use App\Http\Controllers\BooksController;
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
    return view('app');
})->name('home');
Route::get('books', [BooksController::class, 'index']);
Route::post('store', [BooksController::class, 'store']);
Route::get('borrowe/{id}', [BooksController::class, 'returnBook']);
Route::post('borrowebook', [BooksController::class, 'borroweBook']); 