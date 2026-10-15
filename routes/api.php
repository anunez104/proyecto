<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

// Listar y ver publicaciones
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);

// Rutas que requieren autenticación
Route::middleware('auth:sanctum')->group(function () {
    // Crear publicación
    Route::post('/posts', [PostController::class, 'store']);

    // Dar Like
    Route::post('/posts/{id}/like', [PostController::class, 'like']);

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Eliminar publicación
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Comentarios
Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
Route::post('/posts/{id}/comments', [CommentController::class, 'store']);

// Autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);