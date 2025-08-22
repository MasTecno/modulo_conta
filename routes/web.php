<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmpresasController;
use App\Http\Middleware\ConfigConexionDB;
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

    Route::middleware(ConfigConexionDB::class)->group(function () {
        Route::get("/empresas", [EmpresasController::class, "index"])->name("empresas.index");
        Route::post("/sincronizar-sii", [EmpresasController::class, "sincronizarSii"])->name("empresas.sincronizar");
        Route::get("/cargar-planes", [EmpresasController::class, "getPlanesCuenta"])->name("getPlanesCuenta");
        Route::post("/empresas", [EmpresasController::class, "store"])->name("empresas.store");
        Route::get("/listar-empresas", [EmpresasController::class, "getEmpresas"])->name("getEmpresas");
        Route::patch("/empresas/update/{idEmpresa}", [EmpresasController::class, "updateEmpresa"])->name("empresas.update");
        Route::delete("/empresas/delete/{idEmpresa}", [EmpresasController::class, "deleteEmpresa"])->name("empresas.delete");

        Route::get("/representantes", [EmpresasController::class, "indexRepre"])->name("repre.index");
        Route::post("/representantes", [EmpresasController::class, "storeRepre"])->name("repre.store");
        Route::get("/listar-representantes", [EmpresasController::class, "getRepre"])->name("getRepresentantes");
        Route::patch("/representantes/update/{idRepre}", [EmpresasController::class, "updateRepre"])->name("repre.update");
        Route::delete("/representantes/delete/{idRepre}", [EmpresasController::class, "deleteRepre"])->name("repre.delete");
        
        Route::get("/empresa/{uuid}", [EmpresaController::class, "index"])->name("empresa.index");
    });

    
});