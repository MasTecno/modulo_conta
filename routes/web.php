<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\VerificarSesionUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

Route::get("/auth/conta", [AuthController::class, "handle"])->name("handle.token");

Route::middleware(VerificarSesionUsuario::class)->group(function () {

    Route::post("/logout", [AuthController::class, "logout"])->name("logout");

    Route::get("/conta", function () {
        return view("welcome");
    });

});