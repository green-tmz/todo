<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users');
Route::post('/users/block', [UserController::class, 'block'])->middleware(['auth', 'verified'])->name('users.block');
Route::delete('/users/del/{id}', [UserController::class, 'del'])->middleware(['auth', 'verified'])->name('users.del');


Route::get('/projects', [ProjectController::class, 'index'])->middleware(['auth', 'verified'])->name('projects');
Route::post('/projects/add', [ProjectController::class, 'add'])->middleware(['auth', 'verified'])->name('projects.add');
Route::delete('/projects/del/{id}', [ProjectController::class, 'del'])->middleware(['auth', 'verified'])->name('projects.del');
Route::get('/projects/edit/{id}', [ProjectController::class, 'edit'])->middleware(['auth', 'verified'])->name('projects.edit');
Route::post('/projects/edit/{id}', [ProjectController::class, 'postEdit'])->middleware(['auth', 'verified'])->name('projects.edit');

Route::get('/tasks', [TaskController::class, 'index'])->middleware(['auth', 'verified'])->name('tasks');
Route::get('/tasks/add', [TaskController::class, 'add'])->middleware(['auth', 'verified'])->name('tasks.add');
Route::post('/tasks/add', [TaskController::class, 'postAdd'])->middleware(['auth', 'verified'])->name('tasks.add');
Route::delete('/tasks/del/{id}', [TaskController::class, 'del'])->middleware(['auth', 'verified'])->name('tasks.del');
Route::get('/tasks/edit/{id}', [TaskController::class, 'edit'])->middleware(['auth', 'verified'])->name('tasks.edit');
Route::post('/tasks/edit/{id}', [TaskController::class, 'postEdit'])->middleware(['auth', 'verified'])->name('tasks.edit');
Route::post('/tasks/search', [TaskController::class, 'search'])->middleware(['auth', 'verified'])->name('tasks.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
