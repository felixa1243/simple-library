<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/borrow', [BorrowingController::class, 'borrow']);
Route::post('/return', [BorrowingController::class, 'returnBook']);
Route::get('/books',[BookController::class,'index']);
Route::get('/members',[MemberController::class,'index']);