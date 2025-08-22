<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index($uuid) {

        $empresa = DB::connection("conta")
        ->table("empresas")
        ->select("id", "uuid", "rut", "razon_social", "rut_repre", "repre_legal")
        ->where("uuid", $uuid)
        ->first();

        session(["empresaSeleccionada" => $empresa]);

        // if($empresa) abort(404, "Empresa no encontrada");

        return view("empresa.index", compact("empresa"));
    }
}
