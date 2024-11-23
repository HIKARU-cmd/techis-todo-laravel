<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks');     //Routeは以下のリンク先に飛んでください、という内容ルートの意味のまま。今回の場合、ローカルのリンク先に/tasksが入力された時に、第二引数のリンク先のclass内のindexメソッドに飛ぶという指示になっている。->name('tasks')はこの処理に名前を付けているだけ。
Route::post('/task', [App\Http\Controllers\TaskController::class, 'store'])->name('task');
Route::delete('/task/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('/task/{task}');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
