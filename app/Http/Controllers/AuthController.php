<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function handle(Request $request) {
        try {
            $token = $request->query("token");
            // dd($token);

            if (!$token) {
                return abort(403, "No se encuentra el token");
            }

            $publicKeyPath = base_path("keys/public.pem");
    
            if (!file_exists($publicKeyPath)) {
                return abort(500, "No se encuentra la clave");
            }

            $publicKey = file_get_contents($publicKeyPath);
            $data = JWT::decode($token, new Key($publicKey, "RS256"));

            $decoded_array = (array) $data;
            // dd("Decode:\n" . print_r($decoded_array, true) . "\n");
            

            if ($data->expiracion < time()) {
                return redirect()->to("http://127.0.0.1:8000/");
            }

    
            $dbConfig = [
                "host" => "127.0.0.1",
                "database" => $data->database,
                "username" => $data->user,
                "password" => $data->password,
            ];

            session(["db_config" => $dbConfig]);
            session(["indicadores" => $data->indicadores]);
            
            Config::set("database.connections.conta", [
                "driver" => "mysql",
                "host" => $dbConfig["host"],
                "database" => $dbConfig["database"],
                "username" => $dbConfig["username"],
                "password" => $dbConfig["password"],
                "charset" => "utf8mb4",
                "collation" => "utf8mb4_unicode_ci",
            ]);

            $usuario = DB::connection("conta")
            ->table("usuarios")
            ->where("email", $data->email)
            ->first();

            if(!$usuario) {
                return abort(403, "No tienes acceso a este modulo");
            }

            session(["usuario_autenticado" => $usuario]);

            // dd($usuario);
    
            return redirect("/conta");
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout(Request $request) {
        // Limpiar la sesión del usuario
        $request->session()->forget('usuario_autenticado');
        
        // Redirigir al usuario a la página principal
        return redirect()->to("http://127.0.0.1:8000/");
    }
}
