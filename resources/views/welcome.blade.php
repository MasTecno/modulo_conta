@extends("layouts.app")

@section("titulo")
    Módulo Contabilidad
@endsection

@section("contenido")
    
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <div class="container mx-auto px-6 py-5">
            <div class="flex flex-col gap-3 md:flex-row md:gap-0 justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-center md:!text-start mb-2">
                        <i class="fas fa-calculator mr-3"></i>
                        MasContable
                    </h1>
                    <p class="text-blue-100 text-md">Gestión integral de empresas y contabilidad</p>
                </div>
                <div class="text-right flex justify-center items-center gap-3">
                    @php
                        $usuario = session("usuario_autenticado");
                    @endphp
                    <div class="p-2">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/30 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm">{{ $usuario->nombre }} {{ $usuario->ape_paterno }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white/20 hover:bg-white/10 transition-all duration-200 backdrop-blur-sm rounded-lg p-2">
                        <form method="POST" action="{{ route("logout") }}">
                            @csrf
                            <button type="submit" class="cursor-pointer text-sm hover:text-red-500 transition-all duration-200">
                                <i class="fa-solid fa-door-open mr-2"></i>Salir
                            </button>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <!-- Layout para pantallas pequeñas -->
                <div class="block lg:hidden">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-list mr-2 text-blue-600"></i>
                            Lista de Empresas
                        </h3>
                        <a href="{{ route("empresas.index") }}" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 font-medium text-xs shadow-sm">
                            <i class="fa-solid fa-plus mr-1"></i>
                            <span id="textoGrabar">Nueva</span>
                        </a>
                    </div>
                    <div class="w-full">
                        <input type="text" id="buscarEmpresa1" placeholder="Buscar empresa..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">    
                    </div>
                </div>

                <!-- Layout para pantallas grandes -->
                <div class="hidden lg:flex lg:items-center lg:justify-between">
                    <div class="w-3/12">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-list mr-2 text-blue-600"></i>
                            Lista de Empresas
                        </h3>    
                    </div>
                    
                    <div class="w-4/12">
                        <input type="text" id="buscarEmpresa2" placeholder="Buscar empresa..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">    
                    </div>
                    <div class="flex justify-center items-center gap-5">
                        <a href="{{ route("empresas.index") }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 font-medium text-sm shadow-sm">
                            <i class="fa-solid fa-plus mr-2"></i>
                            <span id="textoGrabar">Nueva</span>
                        </a>
                        {{-- <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-600">Activo</span>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-id-card mr-2 text-blue-600"></i>
                                    RUT
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-building mr-2 text-blue-600"></i>
                                    Razón Social
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-cog mr-2 text-blue-600"></i>
                                    Estado
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tablaEmpresas" class="bg-white divide-y divide-gray-200">
                        <!-- Loading State -->
                        <tr id="loadingRow">
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                                    <p class="text-gray-500">Cargando empresas...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State (hidden by default) -->
            <div id="emptyState" class="hidden px-6 py-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-building text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay registros</h3>
                    <p class="text-gray-500 mb-6">Puedes añadir la empresa al sistema.</p>
                    <a href="{{ route("empresas.index") }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Agregar Empresa
                    </a>
                </div>
            </div>
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

        function formatearRut(rut) {
            // Implementación básica de formateo de RUT
            if (!rut) return '';
            return rut.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function filtrarEmpresas(buscar = "") {

            let url;
            const tabla = document.getElementById("tablaEmpresas"); 
            const loadingRow = document.getElementById("loadingRow"); 
            const emptyState = document.getElementById("emptyState");

            if(buscar) {
                url = `{{ url('buscar-empresas') }}/${buscar}`;    
            }else{
                url = `{{ url('listar-empresas') }}`;
            }
            
            fetch(url)
                .then(handleFetchErrors)
                .then(data => {
                    if (data.success) { 

                    // loadingRow.classList.add('hidden'); 
                    if(data.empresas.length === 0) {
                        tabla.innerHTML = ""; 
                        emptyState.classList.remove('hidden'); 
                        
                        
                        return; 
                    } else {
                        emptyState.classList.add('hidden'); 
                        tabla.innerHTML = ""; 
                        data.empresas.forEach((emp, index) => { 
                            const tr = document.createElement("tr"); 
                            tr.classList.add("hover:bg-gray-50", "transition-colors", "duration-200", "cursor-pointer"); 
                            
                            tr.innerHTML = `
                                <td class="px-6 py-1.5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r bg-blue-500 flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">${emp.razon_social.charAt(0).toUpperCase()}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">${formatearRut(emp.rut)}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-1.5">
                                    <div class="text-sm font-medium text-gray-900">${emp.razon_social}</div>
                                </td>
                                <td class="px-6 py-1.5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Activa
                                    </span>
                                </td>
                            `; 
                            
                            tabla.appendChild(tr); 
                            tr.style.transition = "transform 0.2s ease";
                            tr.addEventListener("click", function () {
                                tr.style.transform = "scale(0.97)";

                                setTimeout(() => {
                                    tr.style.transform = "scale(1)";
                                }, 100);

                                setTimeout(() => {
                                    window.location.href = `/empresa/${emp.uuid}`;
                                }, 100);
                            });
                        }); 
                    } 
                } 
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            console.log(url);

        }

        document.addEventListener("DOMContentLoaded", function () {
            filtrarEmpresas();

            const buscar1 = document.getElementById("buscarEmpresa1");
            if (buscar1) {
                buscar1.addEventListener("input", function() {
                    filtrarEmpresas(buscar1.value);
                });
            }

            const buscar2 = document.getElementById("buscarEmpresa2");
            if (buscar2) {
                buscar2.addEventListener("input", function() {
                    filtrarEmpresas(buscar2.value);
                });
            }
        });
    </script>

@endpush