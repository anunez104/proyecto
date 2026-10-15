<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

// Versionado de la API (v1)
Route::prefix('v1')->group(function () {

    // Listar y ver publicaciones (públicas)
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);

    // Ver comentarios (público)
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']);

    // Autenticación
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Rutas que requieren autenticación con Sanctum
    Route::middleware('auth:sanctum')->group(function () {

        // Crear publicación
        Route::post('/posts', [PostController::class, 'store']);

        // Dar Like
        Route::post('/posts/{id}/like', [PostController::class, 'like']);

        // Eliminar publicación
        Route::delete('/posts/{id}', [PostController::class, 'destroy']);

        // Agregar comentario
        Route::post('/posts/{id}/comments', [CommentController::class, 'store']);

        // Cerrar sesión
        Route::post('/logout', [AuthController::class, 'logout']);
    });

});