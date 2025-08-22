@extends("layouts.app")

@section("titulo")
    Modulo Contabilidad
@endsection

@section("navBarConta")
    <x-conta-navbar />
@endsection

@section("contenido")
    
    {{-- <div class="flex justify-end p-6 pt-2">
        <a class="p-1.5 w-50 text-xs text-center bg-slate-600 text-white border border-slate-600 rounded-md mt-4" 
        href="http://127.0.0.1:8000/dashboard">
            <i class="fa-solid fa-power-off mr-1"></i>
            Menu
        </a>
    </div> --}}
  
    @php
        $usuario = session("usuario_autenticado");
    @endphp
    <div class="flex p-6 gap-3">
        <div class="w-1/4">
            <p class="text-sm p-3"><span class="font-semibold">Usuario: </span>{{ $usuario->nombre }} {{ $usuario->ape_paterno }}</p>
        </div>    
        <div class="w-3/4 overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-gray-200 shadow">
                <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            RUT
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Razón Social
                        </th>
                        {{-- <th scope="col" class="px-6 py-3">
                            Dirección
                        </th> --}}
                        {{-- <th scope="col" class="px-6 py-3">
                            Giro
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Ciudad
                        </th> --}}
                        {{-- <th scope="col" class="px-6 py-3">
                            Plan Activo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acción
                        </th> --}}
                    </tr>
                </thead>
                <tbody id="tablaEmpresas">
                    
                </tbody>
            </table>
        </div>
    </div>
    
@endsection

@push("scripts")
    
    <script>

        function handleFetchErrors(response) {
            if (!response.ok) {
                throw Error(response.statusText);
            }
            return response.json();
        }

        function listarEmpresas() {
            const url = "{{ url('listar-empresas') }}";
            
            const tabla = document.getElementById("tablaEmpresas");
            tabla.innerHTML = "";
            fetch(url)
            .then(handleFetchErrors)
            .then(data => {
                console.log(data);
                if (data.success) {
                    
                    if(data.empresas.length === 0) {
                        const tr = document.createElement("tr");
                        tr.classList.add("bg-white", "border-b", "dark:bg-gray-200", "dark:border-gray-200", "border-gray-200", 
                            "hover:bg-gray-50", "hover:bg-gray-100");
                        tabla.appendChild(tr);

                        const td = document.createElement("td");
                        td.classList.add("px-6", "py-2", "font-medium", "text-gray-500");
                        td.colSpan = 5;
                        td.textContent = "No hay registros";
                        tr.appendChild(td);
                    }else{
                        data.empresas.forEach(emp => {
                            const tr = document.createElement("tr");
                            tr.classList.add("bg-white", "border-b", "dark:bg-gray-200", "dark:border-gray-200", "border-gray-200", 
                            "hover:bg-gray-50", "hover:bg-gray-100");
                            tabla.appendChild(tr);

                            const tdRut = document.createElement("td");
                            tdRut.classList.add("text-center", "w-1/4", "px-6", "py-2", "font-medium", "text-gray-900", "whitespace-nowrap", "dark:text-gray-500")
                            tdRut.textContent = formatearRut(emp.rut);
                            tr.appendChild(tdRut);
                            
                            const tdRazonSocial = document.createElement("td");
                            tdRazonSocial.classList.add("w-3/4", "px-6", "py-2", "font-medium", "text-gray-500");
                            tdRazonSocial.textContent = emp.razon_social;
                            tr.appendChild(tdRazonSocial);


                            tr.addEventListener("click", function() {
                                console.log("Cargando datos");
                                window.location.href = `/empresa/${emp.uuid}`;
                            });    

                        });

                    }

                    
                }
            })
            .catch(error => {
                console.error("Error al cargar empresas:", error);
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            listarEmpresas();
        });

    </script>

@endpush