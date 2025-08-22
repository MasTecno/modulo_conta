@extends("layouts.app")

@section("titulo")
    MasContable - Empresas
@endsection

@section("navBarConta")
    <x-conta-navbar />
@endsection

@section("contenido")
    
    <form method="POST" id="formEmpresas">
        @csrf
        
        <!-- Header Section with Actions -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
            <div class="container mx-auto px-2 py-2 pb-2">
                <div class="container mx-auto px-5 max-w-7xl flex flex-col sm:flex-row items-start sm:items-center justify-start gap-4">
                    {{-- <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Gestión de Empresas</h1>
                        <p class="text-blue-100">Administra la información de tus empresas</p>
                    </div> --}}
                    
                    <div class="flex flex-wrap gap-3">
                        <a href="/conta" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-200 font-medium text-sm">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Volver
                        </a>
                        
                        <button type="button" onclick="limpiarFormulario()" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-blue-600 rounded-lg transition-all duration-200 font-medium text-sm shadow-sm">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Nuevo
                        </button>

                        <button type="submit" id="btnGrabar" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 font-medium text-sm shadow-sm">
                            <i class="fa-solid fa-save mr-2"></i>
                            <span id="textoGrabar">Grabar</span>
                        </button>

                        <div class="relative">
                            <button type="button" id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" 
                                    class="inline-flex items-center px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg transition-all duration-200 font-medium text-sm">
                                <i class="fa-solid fa-download mr-2"></i>
                                Exportar
                            </button>
                            
                            <div id="dropdownHover" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 dark:bg-gray-700 absolute right-0 mt-2">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                                            <i class="fa-solid fa-file-csv mr-2"></i>CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white transition-colors">
                                            <i class="fa-solid fa-file-pdf mr-2"></i>PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto mt-6 md:px-1 sm:px-6 py-1 max-w-7xl">
            
            <!-- Company Information Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fa-solid fa-building text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Información de la Empresa</h2>
                            <p class="text-sm text-gray-600">Datos básicos y de contacto</p>
                        </div>
                    </div>
                </div>

                
            
                
                <div class="p-6 space-y-3">
                <!-- Alert Messages -->
                    <div id="divAlert" class="hidden p-2 rounded-lg border-l-4 border-green-500 bg-green-50 mb-6" role="alert">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-check-circle text-green-500 text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800" id="textoAlert"></p>
                            </div>
                        </div>
                    </div>
                    <!-- RUT and SII Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <input type="hidden" id="idEmpresa" name="idEmpresa">
                            <label for="rut" class="block text-sm font-medium text-gray-700">RUT</label>
                            <div class="relative">
                                <input type="text" id="rut" name="rut" 
                                       class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                       placeholder="Ej: 96.900.500-1">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fa-solid fa-id-card text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="claveSii" class="block text-sm font-medium text-gray-700">Clave SII</label>
                            <div class="relative">
                                <input type="text" id="claveSii" name="claveSii" 
                                       class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                       placeholder="Clave SII">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fa-solid fa-key text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end">
                            <button type="button" onclick="sincronizarSii()" 
                                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 font-medium text-sm flex items-center justify-center">
                                <i class="fa-solid fa-sync-alt mr-2"></i>
                                Sincronizar SII
                            </button>
                        </div>
                    </div>

                    <!-- Company Details -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="razonSocial" class="block text-sm font-medium text-gray-700">Razón Social</label>
                            
                                <input type="text" id="razonSocial" name="razonSocial" 
                                    class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                    placeholder="Nombre de la empresa"> 
                                 
                            
                            
                        </div>

                        <div class="space-y-2">
                            <label for="fechaConst" class="block text-sm font-medium text-gray-700">Fecha de Constitución</label>
                            <input type="date" id="fechaConst" name="fechaConst" 
                                   class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        </div>
                    </div>

                    <!-- Legal Representative -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="rutRepre" class="block text-sm font-medium text-gray-700">RUT Representante</label>
                            <input type="text" id="rutRepre" name="rutRepre" 
                                   class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                   placeholder="RUT del representante legal">
                        </div>

                        <div class="space-y-2">
                            <label for="repreLegal" class="block text-sm font-medium text-gray-700">Representante Legal</label>
                            <input type="text" id="repreLegal" name="repreLegal" 
                                   class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                   placeholder="Nombre del representante legal">
                        </div>
                    </div>

                    <!-- Address and Contact -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" id="direccion" name="direccion" 
                                   class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                   placeholder="Dirección de la empresa">
                        </div>

                        <div class="space-y-2">
                            <label for="giro" class="block text-sm font-medium text-gray-700">Giro</label>
                            <input type="text" id="giro" name="giro" 
                                   class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                   placeholder="Giro comercial">
                        </div>

                        <div class="space-y-2">
                            <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <input type="text" id="ciudad" name="ciudad" 
                                   class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                   placeholder="Ciudad">
                        </div>

                        <div class="space-y-2">
                            <label for="correo" class="block text-sm font-medium text-gray-700">Correo</label>
                            <div class="relative">
                                <input type="email" id="correo" name="correo" 
                                    class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                    placeholder="correo@empresa.cl">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fa-solid fa-envelope text-gray-400"></i>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accounting Configuration Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fa-solid fa-calculator text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Configuración Contable</h2>
                            <p class="text-sm text-gray-600">Plan de cuentas y configuración financiera</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label for="planCuenta" class="block text-sm font-medium text-gray-700">Plan de Cuentas</label>
                            <div class="relative">
                                <select id="planCuenta" name="planCuenta" 
                                        class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white appearance-none">
                                    <option value="">Selecciona un Plan de Cuentas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <div class="container mx-auto md:px-1 sm:px-6 py-1 max-w-7xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="bg-white px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fa-solid fa-list text-slate-600 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Empresas Creadas</h2>
                            <p class="text-sm text-gray-600">Empresas registradas en el sistema</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                        <div class="relative w-full">
                            <input type="text" id="searchEmpresa" placeholder="Buscar empresa..." 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fa-solid fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                RUT
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Razón Social
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Dirección
                            </th>
                            {{-- <th scope="col" class="px-6 py-3">
                                Giro
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ciudad
                            </th> --}}
                            <th scope="col" class="px-6 py-3">
                                Plan Activo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tablaEmpresas">
                        
                    </tbody>
                </table>
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

        function sincronizarSii() {
            const rut = document.getElementById("rut").value;
            const claveSii = document.getElementById("claveSii").value;

            if(claveSii == "") {
                mostrarAlerta("Por favor ingresa la clave SII", "error");
                return;
            }

            if(!validarRut(rut)) {
                mostrarAlerta("El RUT ingresado no es válido", "error");
                return;
            }

            // Show loading state
            const btnSincronizar = event.target;
            const originalText = btnSincronizar.innerHTML;
            btnSincronizar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Sincronizando...';
            btnSincronizar.classList.remove("bg-blue-600", "hover:bg-blue-700");
            btnSincronizar.classList.add("bg-blue-400");
            btnSincronizar.disabled = true;

            const url = "{{ url('sincronizar-sii')}}";
            
            fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ rut: rut, clave: claveSii })
            })
            .then(handleFetchErrors)
            .then(data => {
                if (data.success) {
                    const resultado = data.resultado;
                    document.getElementById("razonSocial").value = resultado.razonSocial;
                    document.getElementById("fechaConst").value = resultado.fechaConstitucion;
                    document.getElementById("rutRepre").value = rut;
                    document.getElementById("direccion").value = resultado.calle;
                    document.getElementById("giro").value = resultado.giro;
                    document.getElementById("ciudad").value = resultado.ciudad;
                    document.getElementById("correo").value = resultado.email;
                    mostrarAlerta("Datos sincronizados correctamente desde el SII", "success");
                } else {
                    mostrarAlerta("Error: " + data.message, "error");
                }
            })
            .catch(error => {
                console.error("Error al sincronizar:", error);
                mostrarAlerta("Error al sincronizar con SII", "error");
            })
            .finally(() => {
                btnSincronizar.innerHTML = originalText;
                btnSincronizar.classList.add("bg-blue-600", "hover:bg-blue-700");
                btnSincronizar.disabled = false;
            });
        }

        function ingresarEmpresa(e) {
            e.preventDefault();

            const rut = document.getElementById("rut").value;
            const razonSocial = document.getElementById("razonSocial").value;
            const fechaConst = document.getElementById("fechaConst").value;
            const rutRepre = document.getElementById("rutRepre").value;
            const repreLegal = document.getElementById("repreLegal").value;
            const direccion = document.getElementById("direccion").value;
            const giro = document.getElementById("giro").value;
            const ciudad = document.getElementById("ciudad").value;
            const correo = document.getElementById("correo").value;
            const select = document.getElementById("planCuenta").value;

            const campos = ["rut", "razonSocial", "rutRepre", "repreLegal", "direccion", "giro", "ciudad", "correo", "planCuenta"];

            const camposVacios = campos.some(campo => document.getElementById(campo).value.trim() === "");
                
            if(camposVacios) {
                mostrarAlerta("Por favor completa todos los campos", "error");
                return;
            }

            const empresaData = {
                rut: rut,
                razonSocial: razonSocial,
                fechaConst: fechaConst,
                rutRepre: rutRepre,
                repreLegal: repreLegal,
                direccion: direccion,
                giro: giro,
                ciudad: ciudad,
                correo: correo,
                planCuenta: select
            };

            const idEmpresa = document.getElementById("idEmpresa").value;

            // Show loading state
            const btnGuardar = event.target;
            // const originalText = btnGuardar.innerHTML;
            // btnGuardar.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Guardando...';
            // btnGuardar.disabled = true;
            
            const urlBase = "{{ url('empresas') }}";

            let url, action;

            if(idEmpresa) {
                action = "PATCH";
                url = `${urlBase}/update/${idEmpresa}`;
            }else{
                action = "POST";
                url = `${urlBase}`;
            }

            
            fetch(url, {
                    method: action,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(empresaData)
                })
                .then(handleFetchErrors)
                .then(data => {
                    if (data.success) {
                        mostrarAlerta(data.message, "success");
                        limpiarFormulario();
                        listarEmpresas();
                    } else if (data.warning) {
                        mostrarAlerta(data.message, "warning");
                    } else {
                        mostrarAlerta("Error: " + data.message, "error");
                    }
                })
                .catch(error => {
                    console.error("Error al enviar:", error);
                    mostrarAlerta("Error al guardar la empresa", "error");
                })
                .finally(() => {
                    // Restore button state
                    // btnGuardar.innerHTML = originalText;
                    btnGuardar.disabled = false;
                });
        }

        function cargarPlanes() {
            const url = "{{ url('cargar-planes')}}";
            const select = document.getElementById("planCuenta");

            fetch(url)
            .then(handleFetchErrors)
            .then(data => {
                if (data.success) {
                    data.planes.forEach(plan => {
                        const option = document.createElement("option");
                        option.value = plan.id;
                        option.textContent = plan.nombre;
                        select.appendChild(option);
                    });
                } else {
                    mostrarAlerta("Error al cargar planes de cuenta: " + data.message, "error");
                }
            })
            .catch(error => {
                console.error("Error al cargar planes de cuenta:", error);
                mostrarAlerta("Error al cargar planes de cuenta", "error");
            });
        }

        function mostrarAlerta(mensaje, tipo) {
            const divAlert = document.getElementById("divAlert");

            divAlert.className = "p-2 rounded-lg border-l-4 mb-6";

            if (tipo === "success") {
                divAlert.classList.add("border-green-500", "bg-green-50");
            } else if (tipo === "warning") {
                divAlert.classList.add("border-yellow-500", "bg-yellow-50");
            } else {
                divAlert.classList.add("border-red-500", "bg-red-50");
            }

            // Limpiar contenido anterior
            divAlert.innerHTML = "";


            const contenedor = document.createElement("div");
            contenedor.className = "flex items-center";

            const iconWrapper = document.createElement("div");
            iconWrapper.className = "flex-shrink-0";

            const icon = document.createElement("i");
            icon.classList.add("fa-solid", "text-lg");
    
            if (tipo === "success") {
                icon.classList.add("fa-check-circle", "text-green-500");
            } else if (tipo === "warning") {
                icon.classList.add("fa-triangle-exclamation", "text-yellow-500");
            } else {
                icon.classList.add("fa-exclamation-circle", "text-red-500");
            }

            const textoWrapper = document.createElement("div");
            textoWrapper.className = "ml-3";

            const texto = document.createElement("p");
            texto.className = "text-sm font-medium";
            texto.textContent = mensaje;

            if (tipo === "success") {
                texto.classList.add("text-green-800");
            } else if (tipo === "warning") {
                texto.classList.add("text-yellow-800");
            } else {
                texto.classList.add("text-red-800");
            }

            iconWrapper.appendChild(icon);
            textoWrapper.appendChild(texto);
            contenedor.appendChild(iconWrapper);
            contenedor.appendChild(textoWrapper);
            divAlert.appendChild(contenedor);

            divAlert.classList.remove("hidden");

            setTimeout(() => {
                divAlert.classList.add("hidden");
            }, 3500);
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
                            tdRut.classList.add("px-6", "py-1", "font-medium", "text-gray-900", "whitespace-nowrap", "dark:text-gray-500")
                            tdRut.textContent = formatearRut(emp.rut);
                            tr.appendChild(tdRut);
                            
                            const tdRazonSocial = document.createElement("td");
                            tdRazonSocial.classList.add("px-6", "py-1", "font-medium", "text-gray-500");
                            tdRazonSocial.textContent = emp.razon_social;
                            tr.appendChild(tdRazonSocial);

                            const tdDireccion = document.createElement("td");
                            tdDireccion.classList.add("px-6", "py-1", "font-medium", "text-gray-500");
                            tdDireccion.textContent = emp.direccion;
                            tr.appendChild(tdDireccion);

                            const tdPlanActivo = document.createElement("td");
                            tdPlanActivo.classList.add("px-6", "py-1", "font-medium", "text-gray-500");
                            tdPlanActivo.textContent = emp.nombre;
                            tr.appendChild(tdPlanActivo);

                            const tdAccion = document.createElement("td");
                            tdAccion.classList.add("px-6", "py-1", "font-medium", "text-gray-500")

                            const divAccion = document.createElement("div");
                            const btnEliminar = document.createElement("button");
                            btnEliminar.classList.add("cursor-pointer", "bg-red-500", "p-1.5", "w-25", "font-medium", "transition-all", "duration-200", "text-white", "border", "rounded-md", "hover:bg-red-600");
                            
                            const iconoEliminar = document.createElement("i");
                            iconoEliminar.classList.add("fa-solid", "fa-trash", "mr-2");

                            const textoEliminar = document.createElement("span");
                            textoEliminar.classList.add("text-sm");
                            textoEliminar.textContent = "Eliminar";

                            btnEliminar.appendChild(iconoEliminar);
                            btnEliminar.appendChild(textoEliminar);

                            btnEliminar.addEventListener("click", function(e) {
                                e.stopPropagation();
                                eliminarEmpresa(emp.id);
                            });
                            
                            tdAccion.appendChild(divAccion);
                            tr.appendChild(tdAccion);
                            divAccion.appendChild(btnEliminar);

                            tr.addEventListener("click", function() {
                                console.log("Cargando datos");
                                const rutInput = document.getElementById("rut");
                                document.getElementById("idEmpresa").value = emp.id;
                                rutInput.value = formatearRut(emp.rut);
                                rutInput.classList.remove("bg-white");
                                rutInput.classList.add("bg-gray-200");
                                rutInput.readOnly = true;

                                document.getElementById("razonSocial").value = emp.razon_social;
                                document.getElementById("fechaConst").value = emp.fecha_constitucion;
                                document.getElementById("rutRepre").value = emp.rut_repre;
                                document.getElementById("repreLegal").value = emp.repre_legal;
                                document.getElementById("direccion").value = emp.direccion;
                                document.getElementById("giro").value = emp.giro;
                                document.getElementById("ciudad").value = emp.ciudad;
                                document.getElementById("correo").value = emp.correo;
                                document.getElementById("planCuenta").value = emp.id_plan_cuenta;

                                const textoGrabar = document.getElementById("textoGrabar");
                                textoGrabar.textContent = "Actualizar";
                                
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            
                            });    

                        });

                    }

                    
                }
            })
            .catch(error => {
                console.error("Error al cargar empresas:", error);
            });
        }

        function eliminarEmpresa(idEmpresa) {
            if (!confirm("¿Estás seguro de que deseas eliminar esta empresa?")) {
                return;
            }
            
            const url = `{{ url('empresas') }}/delete/${idEmpresa}`;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(handleFetchErrors)
            .then(data => {
                if (data.success) {
                    mostrarAlerta(data.message, "success");
                    listarEmpresas();
                    limpiarFormulario();
                } else {
                    mostrarAlerta("Error al eliminar empresa: " + data.message, "error");
                }
            })
            .catch(error => {
                console.error("Error al eliminar empresa:", error);
                mostrarAlerta("Error al eliminar empresa", "error");
            });
        }
        
        function limpiarFormulario() {
            document.getElementById("idEmpresa").value = "";
            const rutInput = document.getElementById("rut");
            rutInput.classList.remove("bg-gray-200");
            rutInput.classList.add("bg-white");
            rutInput.readOnly = false;
            rutInput.value = "";
            
            document.getElementById("claveSii").value = "";
            document.getElementById("razonSocial").value = "";
            document.getElementById("fechaConst").value = "";
            document.getElementById("rutRepre").value = "";
            document.getElementById("repreLegal").value = "";
            document.getElementById("direccion").value = "";
            document.getElementById("giro").value = "";
            document.getElementById("ciudad").value = "";
            document.getElementById("correo").value = "";
            document.getElementById("planCuenta").value = "";
            document.getElementById("textoGrabar").textContent = "Grabar";
        }


        document.addEventListener("DOMContentLoaded", function () {
            cargarPlanes();
            listarEmpresas();
            document.getElementById("rut").addEventListener("blur", function () {
                let valor = this.value.trim();

                if (!valor) {
                    this.value = "";
                    return;
                }

                let rutFormateado = formatearRut(valor);

                if (rutFormateado === "-") {
                    this.value = "";
                    return;
                }

                if (rutFormateado.length > 12) {
                    rutFormateado = rutFormateado.slice(0, 12);
                }

                this.value = rutFormateado;
            });

            document.getElementById("formEmpresas").addEventListener("submit", ingresarEmpresa);
        });
    </script>

@endpush