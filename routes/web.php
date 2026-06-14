<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/blog', function () {
    return view('blog.index');
})->name('blog');

Route::get('/blog/{id}', function ($id) {
    return view('blog.show');
})->name('blog.show');

Route::get('/data', function () {
    return view('admin.data', [
        'users'    => User::orderBy('id')->get(),
        'posts'    => Post::with('user')->orderBy('id')->get(),
        'comments' => Comment::with(['user', 'post'])->orderBy('id')->get(),
    ]);
});
