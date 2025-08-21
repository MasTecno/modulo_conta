<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresasController extends Controller
{
    
    public function index() {
        return view("empresas.index");
    }

    public function sincronizarSii(Request $request) {

        $urut = $request->rut;
        $clave = $request->clave;

        try {

            $cookieFile = storage_path("app/cookies_$urut.txt");
            $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36";

            $rut = substr(str_replace(".", "", $urut), 0, -2);
            $dv = substr($urut, -1);

            // return response()->json([
            //     "success" => true,
            //     "data" => "Rut: $rut y dv $dv"
            // ]);
            
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://zeusr.sii.cl/cgi_AUT2000/CAutInicio.cgi',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query([
                    "rutcntr"     => $rut,
                    "clave"       => $clave,
                    "rut"         => $rut,
                    "referencia"  => 'https://misiir.sii.cl/cgi_misii/siihome.cgi',
                    "dv"          => $dv,
                    "411"         => "",
                ]),
                CURLOPT_USERAGENT => $userAgent,
                CURLOPT_COOKIEJAR => $cookieFile,
                CURLOPT_COOKIEFILE => $cookieFile,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
                CURLOPT_REFERER => 'https://zeusr.sii.cl//AUT2000/InicioAutenticacion/IngresoRutClave.html?https://misiir.sii.cl/cgi_misii/siihome.cgi',
            ]);

            $loginResult = curl_exec($ch);
            $loginCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            curl_close($ch);

            if($loginCode != 200) {
                return response()->json(["error" => true, "message" => "Error al sincronizar"], 500);
            }


            curl_setopt_array($ch, [
                CURLOPT_URL => "https://misiir.sii.cl/cgi_misii/siihome.cgi",
                CURLOPT_POST => false,
                CURLOPT_HTTPGET => true,
                CURLOPT_REFERER => "https://zeusr.sii.cl/cgi_AUT2000/CAutInicio.cgi",
            ]);

            $homeResult = curl_exec($ch);
            $homeCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($homeCode != 200) {
                return response()->json(["success" => false, "message" => "Error al acceder a home SII"], 500);
            }

            libxml_use_internal_errors(true);
            $dom = new DOMDocument("1.0", "UTF-8");
            $htmlUtf8 = "<?xml encoding='UTF-8'>" . $homeResult;
            $dom->loadHTML($htmlUtf8, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $scripts = $dom->getElementsByTagName("script");
            $mscript = null;

            foreach ($scripts as $script) {
                $code = $script->nodeValue;
                if (substr_count($code, "DatosCntrNow") > 0) {
                    $mscript = $code;
                }
            }

            preg_match_all('/(?<=\sDatosCntrNow\s=\s)(.*?)(?=;)/', $mscript, $coincidencias);

            $script = $coincidencias[0][0];
            $parsed = json_decode($script, true);

            // if (!$parsed) {
            //     return response()->json(["error" => true, "message" => "Error al decodificar datos del contribuyente"], 500);
            // }

            $razonSocial = $parsed["contribuyente"]["razonSocial"];
            $rutEmpresa = $parsed["contribuyente"]["rut"] . "-" . $parsed["contribuyente"]["dv"];
            $fechaConstitucion = $parsed["contribuyente"]["fechaConstitucion"];
            $glosaActividad = $parsed["contribuyente"]["glosaActividad"];
            $calle = $parsed["direcciones"][0]["calle"];
            $ciudad = $parsed["direcciones"][0]["ciudad"];
            $email = $parsed["contribuyente"]["eMail"];

            if($razonSocial==""){
                $razonSocial = strtoupper($parsed["contribuyente"]["nombres"]." ".$parsed["contribuyente"]["apellidoPaterno"]." ".$parsed["contribuyente"]["apellidoMaterno"]);
            }

            if($ciudad==""){
                $ciudad = strtoupper($parsed["direcciones"][0]["comunaDescripcion"]);
            }

            $data = [
                "razonSocial" => $razonSocial,
                "fechaConstitucion" => date("Y-m-d", strtotime($fechaConstitucion)),
                "giro" => $glosaActividad,
                "calle" => $calle,
                "ciudad" => $ciudad,
                "email" => $email,
            ];

            return response()->json([
                "success" => true,
                "resultado" => $data
            ], 200);

        } catch(\Throwable $e) {
            return response()->json([
                "error" => true,
                "message" => "Error interno: " . $e->getMessage()
            ], 500);
        }

    }

    public function getPlanesCuenta() {

        $planesCuenta = DB::connection("conta")->table("plan_cuenta")->select("id", "nombre")->get();

        return response()->json([
            "success" => true,
            "planes" => $planesCuenta
        ]);

    }

    public function store(Request $request) {

        $request->validate([
            "rut" => ["required"],
            "razonSocial" => ["required"],
            "rutRepre" => ["required"],
            "repreLegal" => ["required"],
            "direccion" => ["required"],
            "giro" => ["required"],
            "ciudad" => ["required"],
            "correo" => ["required"],
            "planCuenta" => ["required"]
        ]);

        $rut = str_replace(".", "", $request->rut);
        $rutRepre = str_replace(".", "", $request->rutRepre);

        $validar = DB::connection("conta")
        ->table("empresas")->select("rut")
        ->where("rut", $rut)
        ->first();

        if($validar) {
            return response()->json([
                "warning" => true,
                "message" => "La empresa ya fue registrada"
            ]);
        }

        $nuevaEmpresa = DB::connection("conta")
        ->table("empresas")
        ->insertGetId([
            "rut" => $rut,
            "razon_social" => $request->razonSocial,
            "fecha_constitucion" => $request->fechaConst,
            "rut_repre" => $rutRepre,
            "repre_legal" => $request->repreLegal,
            "direccion" => $request->direccion,
            "giro" => $request->giro,
            "ciudad" => $request->ciudad,
            "correo" => $request->correo,
            "id_plan_cuenta" => $request->planCuenta,
            "estado" => "A",
            "created_at" => now(),
            "updated_at" => now()
        ]);

        if (!$nuevaEmpresa) {
            return response()->json([
                "error" => true,
                "message" => "Error al registrar la empresa"
            ], 500);
        }

        return response()->json([
            "success" => true,
            "message" => "Se registro la empresa"
        ], 200);

    }

    public function getEmpresas() {

        $empresas = DB::connection("conta")->table("empresas as emp")
        ->join("plan_cuenta as pla", "emp.id_plan_cuenta", "=", "pla.id")
        ->select("emp.id", "emp.rut", "emp.razon_social", "emp.fecha_constitucion", "emp.rut_repre", "emp.repre_legal", 
        "emp.direccion", "emp.giro", "emp.ciudad", "emp.correo", "emp.id_plan_cuenta", "pla.nombre")
        ->get();

        return response()->json([
            "success" => true,
            "empresas" => $empresas
        ], 200);

    }

    public function updateEmpresa(Request $request, $idEmpresa) {

        $request->validate([
            "rut" => ["required"],
            "razonSocial" => ["required"],
            "rutRepre" => ["required"],
            "repreLegal" => ["required"],
            "direccion" => ["required"],
            "giro" => ["required"],
            "ciudad" => ["required"],
            "correo" => ["required"],
            "planCuenta" => ["required"]
        ]);

        $rut = str_replace(".", "", $request->rut);
        $rutRepre = str_replace(".", "", $request->rutRepre);

        $editarEmpresa = DB::connection("conta")
        ->table("empresas")
        ->where("id", $idEmpresa)
        ->update([
            "rut" => $rut,
            "razon_social" => $request->razonSocial,
            "fecha_constitucion" => $request->fechaConst,
            "rut_repre" => $rutRepre,
            "repre_legal" => $request->repreLegal,
            "direccion" => $request->direccion,
            "giro" => $request->giro,
            "ciudad" => $request->ciudad,
            "correo" => $request->correo,
            "id_plan_cuenta" => $request->planCuenta,
            "estado" => "A",
            "updated_at" => now()
        ]);

        if (!$editarEmpresa) {
            return response()->json([
                "error" => true,
                "message" => "Error al editar la empresa"
            ], 500);
        }

        return response()->json([
            "success" => true,
            "message" => "Se actualizo la empresa"
        ], 200);

    }

    public function deleteEmpresa($idEmpresa) {

        try {
            $empresa = DB::connection("conta")
                ->table("empresas")
                ->where("id", $idEmpresa)
                ->first();

            if (!$empresa) {
                return response()->json([
                    "error" => true,
                    "message" => "La empresa no existe"
                ], 404);
            }

            $eliminada = DB::connection("conta")
                ->table("empresas")
                ->where("id", $idEmpresa)
                ->delete();

            if (!$eliminada) {
                return response()->json([
                    "error" => true,
                    "message" => "Error al eliminar la empresa"
                ], 500);
            }

            return response()->json([
                "success" => true,
                "message" => "Se elimino una empresa"
            ], 200);

        } catch(\Throwable $e) {
            return response()->json([
                "error" => true,
                "message" => "Error interno: " . $e->getMessage()
            ], 500);
        }

    }

    public function indexRepre() {
        return view("empresas.representantes");
    }

    public function storeRepre(Request $request) {

        $request->validate([
            "empresa" => ["required"],
            "rutRepre" => ["required"],
            "repreLegal" => ["required"]
        ]);

        $rutRepre = str_replace(".", "", $request->rutRepre);

        $validarRepre = DB::connection("conta")
        ->table("representantes")->select("rut_repre")
        ->where("rut_repre", $rutRepre)
        ->first();

        $validarEmp = DB::connection("conta")
        ->table("empresas")->select("rut_repre")
        ->where("rut_repre", $rutRepre)
        ->first();

        if($validarRepre || $validarEmp) {
            return response()->json([
                "warning" => true,
                "message" => "El representante ya existe"
            ]);
        }

        $nuevaEmpresa = DB::connection("conta")
        ->table("representantes")
        ->insertGetId([
            "id_empresa" => $request->empresa,
            "rut_repre" => $rutRepre,
            "repre_legal" => $request->repreLegal,
            "estado" => "A",
            "created_at" => now(),
            "updated_at" => now()
        ]);

        if (!$nuevaEmpresa) {
            return response()->json([
                "error" => true,
                "message" => "Error al registrar un representante"
            ], 500);
        }

        return response()->json([
            "success" => true,
            "message" => "Se registro un representante"
        ], 200);
    }

    public function getRepre() {

        $representantes = DB::connection("conta")->table("representantes as rep")
        ->join("empresas as emp", "rep.id_empresa", "=", "emp.id")
        ->select("rep.id", "rep.id_empresa", "rep.rut_repre", "rep.repre_legal", "emp.razon_social as empresa_nombre")
        ->get();

        return response()->json([
            "success" => true,
            "representantes" => $representantes
        ], 200);

    }

    public function updateRepre(Request $request, $idRepre) {

        $request->validate([
            "empresa" => ["required"],
            "rutRepre" => ["required"],
            "repreLegal" => ["required"]
        ]);

        $rutRepre = str_replace(".", "", $request->rutRepre);

        $validarEmp = DB::connection("conta")
        ->table("empresas")->select("rut_repre")
        ->where("rut_repre", $rutRepre)
        ->first();

        if($validarEmp) {
            return response()->json([
                "warning" => true,
                "message" => "El representante ya existe"
            ]);
        }

        $editarRepre = DB::connection("conta")
        ->table("representantes")
        ->where("id", $idRepre)
        ->update([
            "id_empresa" => $request->empresa,  
            "rut_repre" => $rutRepre,
            "repre_legal" => $request->repreLegal,
            "estado" => "A",
            "updated_at" => now()
        ]);
        
        if (!$editarRepre) {
            return response()->json([
                "error" => true,
                "message" => "Error al editar el representante"
            ], 500);
        }

        return response()->json([
            "success" => true,
            "message" => "Se actualizo el representante"
        ], 200);

    }

    public function deleteRepre($idRepre) {

        try {

            $eliminar = DB::connection("conta")
                ->table("representantes")
                ->where("id", $idRepre)
                ->delete();

            if (!$eliminar) {
                return response()->json([
                    "error" => true,
                    "message" => "Error al eliminar el representante"
                ], 500);
            }

            return response()->json([
                "success" => true,
                "message" => "Se elimino un representante"
            ], 200);

        } catch(\Throwable $e) {
            return response()->json([
                "error" => true,
                "message" => "Error interno: " . $e->getMessage()
            ], 500);
        }

    }

}
