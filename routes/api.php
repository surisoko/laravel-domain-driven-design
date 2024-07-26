<?php

use Illuminate\Support\Facades\Route;
use App\User\Infrastructure\Controller\CreateUserController;
use App\User\Infrastructure\Controller\GetVerifiedUsersController;
use App\User\Infrastructure\Controller\VerifyUserController;

Route::post('/user', CreateUserController::class)->name('create.user');
Route::get('/users', GetVerifiedUsersController::class)->name('list.users');
Route::put('/user/{id}/verify', VerifyUserController::class)->name('verify.user');
