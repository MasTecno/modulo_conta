<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("titulo")</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/b8e5063394.js" crossorigin="anonymous"></script>
</head>
<body class="flex flex-col min-h-screen">

    @yield("navBarConta")
    
    <div class="bg-red-500 p-1">
        @php
          $indicadoresApi = session("indicadores");
        @endphp
        <div class="flex flex-wrap gap-3 pl-6 text-white text-sm font-semibold">
            @if($indicadoresApi)
                <span>Dolar: ${{ $indicadoresApi->dolar }}</span>
                <span>Euro: ${{ $indicadoresApi->euro }}</span>
                <span>UF: ${{ $indicadoresApi->uf }}</span>
                <span>UTM: ${{ $indicadoresApi->utm }}</span>
                <span>IPC: {{ $indicadoresApi->ipc }}</span>
                <span>IVP: {{ $indicadoresApi->ivp }}</span>
                <span>Imacec: {{ $indicadoresApi->imacec }}</span>
            @endif     
        </div>
    </div>

    <main class="flex-1">
        @yield("contenido")    
    </main>
    

    <footer class="text-center p-4 bg-gray-500 mt-auto">
        <h6 class="text-white font-semibold text-sm">&reg; {{ now()->format("Y") }} MasContable | Desarrollado por 
            <a href="https://mastecno.cl" target="_blank" class="hover:text-red-500 font-bold">MasTecno</a>
        </h6>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        function formatearRut(rut) {
            rut = rut.replace(/\./g, '').replace(/-/g, '');
                    
            const dv = rut.slice(-1);
            let rutNumero = rut.slice(0, -1);
            rutNumero = rutNumero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    
            return rutNumero + "-" + dv;
        }

        function validarRut(rut) {
            rut = rut.replace(/\./g, '').replace(/-/g, '');
            
            // Obtener dígito verificador
            let dv = rut.slice(-1);
            let rutNumero = parseInt(rut.slice(0, -1));

            // Calcular dígito verificador
            let suma = 0;
            let multiplicador = 2;
            while (rutNumero > 0) {
                suma += (rutNumero % 10) * multiplicador;
                rutNumero = Math.floor(rutNumero / 10);
                multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
            }
            let dvCalculado = 11 - (suma % 11);
            let dvEsperado = dvCalculado === 11 ? '0' : dvCalculado === 10 ? 'K' : dvCalculado.toString();

            return dv.toUpperCase() === dvEsperado;
        }
    </script>
    @stack("scripts")
</body>
</html>