<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ConfigConexionDB
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dbConfig = session("db_config");

        if($dbConfig) {

            //* Limpiar conexiones previas en caso de existir
            DB::purge("conta");

            //* Crear la conexion dinamica para conta
            Config::set("database.connections.conta", [
                "driver" => "mysql",
                "host" => $dbConfig["host"],
                "database" => $dbConfig["database"],
                "username" => $dbConfig["username"],
                "password" => $dbConfig["password"],
                "charset" => "utf8mb4",
                "collation" => "utf8mb4_unicode_ci",
            ]);

            //* Conectar la nueva configuracion
            DB::reconnect("conta");
        }


        return $next($request);
    }
}
