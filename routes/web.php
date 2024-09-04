<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;

Route::get('/auth', [AuthController::class, 'login'])->name('login');

Route::post('/auth', [AuthController::class, 'auth']);

Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [IndexController::class, 'index'])->name('index')->middleware('auth');

Route::get('/admin', [AdminController::class, 'admin'])->name('admin')->middleware('auth');

Route::get('/admin/users', [AdminController::class, 'users'])->name('admin-users')->middleware('auth');

Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin-roles')->middleware('auth');

Route::get('/admin/departments', [AdminController::class, 'departments'])->name('admin-departments')->middleware('auth');

Route::get('/admin/{department}/tasks', [AdminController::class, 'tasks'])->name('admin-tasks')->middleware('auth');

Route::get('/users', [IndexController::class, 'users'])->name('users')->middleware('auth');

Route::post('/users/create', [AuthController::class, 'create'])->name('create-user')->middleware('auth');

Route::get('/users/edit/{user}', [AuthController::class, 'edit'])->name('edit-user')->middleware('auth');

Route::put('/users/edit/{user}', [AuthController::class, 'put'])->name('edit-user')->middleware('auth');

Route::delete('/users/edit/{user}', [AuthController::class, 'delete'])->name('edit-user')->middleware('auth');

Route::post('/roles/create', [RoleController::class, 'create'])->name('create-role')->middleware('auth');

Route::get('/roles/edit/{role}', [RoleController::class, 'edit'])->name('edit-role')->middleware('auth');

Route::put('/roles/edit/{role}', [RoleController::class, 'put'])->name('edit-role')->middleware('auth');

Route::delete('/roles/edit/{role}', [RoleController::class, 'delete'])->name('edit-role')->middleware('auth');

Route::post('/departments/create', [DepartmentController::class, 'create'])->name('create-department')->middleware('auth');

Route::get('/departments/edit/{department}', [DepartmentController::class, 'edit'])->name('edit-department')->middleware('auth');

Route::put('/departments/edit/{department}', [DepartmentController::class, 'put'])->name('edit-department')->middleware('auth');

Route::delete('/departments/edit/{department}', [DepartmentController::class, 'delete'])->name('edit-department')->middleware('auth');

Route::get('/tasks', [IndexController::class, 'tasks'])->name('tasks')->middleware('auth');

Route::post('/tasks/create', [TaskController::class, 'create'])->name('create-task')->middleware('auth');

Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('edit-task')->middleware('auth');

Route::put('/tasks/edit/{task}', [TaskController::class, 'put'])->name('edit-task')->middleware('auth');

Route::delete('/tasks/edit/{task}', [TaskController::class, 'delete'])->name('edit-task')->middleware('auth');

Route::put('/tasks/comments/{comment}', [CommentController::class, 'put'])->name('edit-comment')->middleware('auth');

Route::delete('/tasks/comments/{comment}', [CommentController::class, 'delete'])->name('edit-comment')->middleware('auth');

Route::patch('/tasks/comments/reply/{comment}', [CommentController::class, 'reply'])->name('reply-comment')->middleware('auth');

Route::post('/tasks/{task}/comment', [CommentController::class, 'create'])->name('create-comment')->middleware('auth');

Route::get('/tasks/{task}/assign', [TaskController::class, 'assign'])->name('assign-task')->middleware('auth');

Route::get('/tasks/{task}/deassign', [TaskController::class, 'deassign'])->name('deassign-task')->middleware('auth');

Route::get('/tasks/{task}/progress', [TaskController::class, 'progress'])->name('progress-task')->middleware('auth');

Route::get('/tasks/{task}/done', [TaskController::class, 'done'])->name('done-task')->middleware('auth');

Route::get('/tasks/{task}/cancel', [TaskController::class, 'cancel'])->name('cancel-task')->middleware('auth');

Route::post('/tasks/{task}/mark', [TaskController::class, 'mark'])->name('mark-task')->middleware('auth');

Route::get('/tasks/{task}', [TaskController::class, 'task'])->name('task')->middleware('auth');



