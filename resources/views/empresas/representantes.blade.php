@extends("layouts.app")

@section("titulo")
    MasContable - Representantes
@endsection

@section("contenido")
 
<form method="POST" id="formRepre">
    @csrf
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

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-all duration-200 font-medium text-sm shadow-sm">
                    <i class="fa-solid fa-save mr-2"></i>
                    <span id="textoGrabar">Grabar</span>
                </button>

                <a href="{{ route("empresas.index") }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 font-medium text-sm shadow-sm">
                    <i class="fa-solid fa-building mr-2"></i>
                    Empresas
                </a>

            </div>
        </div>
    </div>
</div>

        <div class="container mx-auto mt-6 px-1 py-1 max-w-7xl">
            
            <!-- Company Information Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fa-solid fa-users text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Añadir representantes</h2>
                            <p class="text-sm text-gray-600">Datos de los representantes asociados a una empresa</p>
                        </div>
                    </div>
                </div>

                
            
                
                <div class="pb-6 pl-6 pr-6 pt-5 space-y-3">
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

                    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <input type="hidden" id="idRepre" name="idRepre">
                            <div class="space-y-2">
                                <label for="selectEmpresa" class="block text-sm font-medium text-gray-700">Empresa</label>
                                <div class="relative">
                                    <select id="selectEmpresa" name="selectEmpresa" 
                                            class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white appearance-none">
                                        <option value="">Selecciona una Empresa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RUT and SII Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            
                            <label for="rutRepre" class="block text-sm font-medium text-gray-700">RUT Representante</label>
                            <div class="relative">
                                <input type="text" id="rutRepre" name="rutRepre" 
                                       class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                       placeholder="Ej: 96.900.500-1">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fa-solid fa-id-card text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="repreLegal" class="block text-sm font-medium text-gray-700">Representante Legal</label>
                            <div class="relative">
                                <input type="text" id="repreLegal" name="repreLegal" 
                                       class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                       placeholder="Representante Legal">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fa-solid fa-key text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Company Details -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="telefonoRepre" class="block text-sm font-medium text-gray-700">Telefono</label>
                            
                            <input type="text" id="telefonoRepre" name="telefonoRepre" 
                                class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                placeholder="Telefono"> 
                              
                        </div>

                        <div class="space-y-2">
                            <label for="correoRepre" class="block text-sm font-medium text-gray-700">Correo</label>
                            <input type="email" id="correoRepre" name="correoRepre" 
                                class="w-full px-4 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                                placeholder="Correo">
                        </div>
                    </div> --}}

                    
                </div>
            </div>

            
        </div>
    </div>
</form>

<div class="container mx-auto md:px-1 sm:px-6 py-1 max-w-7xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
    <div class="bg-white px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fa-solid fa-list text-slate-600 text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Representantes Creados</h2>
                    <p class="text-sm text-gray-600">Representantes ingresados en el sistema</p>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs uppercase bg-gray-50 text-gray-600">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Empresa
                    </th>
                    <th scope="col" class="px-6 py-3">
                        RUT
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Representante Legal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acción
                    </th>
                </tr>
            </thead>
            <tbody id="tablaRepresentantes">
                
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

        function cargarEmpresas() {
            const url = "{{ url('listar-empresas')}}";
            const select = document.getElementById("selectEmpresa");
            
            fetch(url)
            .then(handleFetchErrors)
            .then(data => {
                console.log(data);
                if (data.success) {
                    if(data.empresas.length === 0)  {
                    select.innerHTML = "";
                        const option = document.createElement("option");
                        option.value = "";
                        option.textContent = "No hay empresas";
                        select.classList.remove("bg-white");
                        select.classList.add("bg-gray-200");
                        select.disabled = true;
                        select.appendChild(option);
                    }else{
                        select.classList.remove("bg-gray-200");
                        select.classList.add("bg-white");
                        select.disabled = false;
                        data.empresas.forEach(emp => {
                            const option = document.createElement("option");
                            option.value = emp.id;
                            option.textContent = emp.razon_social;
                            select.appendChild(option);
                        });    
                    }
                    
                } else {
                    mostrarAlerta("Error al cargar empresas: " + data.message, "error");
                }
            })
            .catch(error => {
                console.error("Error al cargar empresas:", error);
                mostrarAlerta("Error al cargar empresas", "error");
            });
        }

        function listarRepresentantes() {
            const url = "{{ url('listar-representantes') }}";
            
            const tabla = document.getElementById("tablaRepresentantes");
            tabla.innerHTML = "";
            fetch(url)
            .then(handleFetchErrors)
            .then(data => {
                console.log(data);
                if (data.success) {
                    
                    if(data.representantes.length === 0) {
                        const tr = document.createElement("tr");
                        tr.classList.add("bg-white", "border-b", "dark:bg-gray-200", "dark:border-gray-200", "border-gray-200", 
                            "hover:bg-gray-50", "hover:bg-gray-100");
                        tabla.appendChild(tr);

                        const td = document.createElement("td");
                        td.classList.add("px-6", "py-2", "font-medium", "text-gray-500");
                        td.colSpan = 4;
                        td.textContent = "No hay registros";
                        tr.appendChild(td);
                    }else{

                        data.representantes.forEach(rep => {
                            const tr = document.createElement("tr");
                            tr.classList.add("bg-white", "border-b", "dark:bg-gray-200", "dark:border-gray-200", "border-gray-200", 
                            "hover:bg-gray-50", "hover:bg-gray-100");
                            tabla.appendChild(tr);

                            const tdEmpresa = document.createElement("td");
                            tdEmpresa.classList.add("px-6", "py-1", "font-medium", "text-gray-900", "whitespace-nowrap", "dark:text-gray-500")
                            tdEmpresa.textContent = rep.empresa_nombre;
                            tr.appendChild(tdEmpresa);
                            
                            const tdRutRepre = document.createElement("td");
                            tdRutRepre.classList.add("px-6", "py-1", "font-medium", "text-gray-500");
                            tdRutRepre.textContent = formatearRut(rep.rut_repre);
                            tr.appendChild(tdRutRepre);

                            const tdRepreLegal = document.createElement("td");
                            tdRepreLegal.classList.add("px-6", "py-1", "font-medium", "text-gray-500");
                            tdRepreLegal.textContent = rep.repre_legal;
                            tr.appendChild(tdRepreLegal);

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
                                eliminarRepresentante(rep.id);
                            });
                            
                            tdAccion.appendChild(divAccion);
                            tr.appendChild(tdAccion);
                            divAccion.appendChild(btnEliminar);

                            tr.addEventListener("click", function() {
                                console.log("Cargando datos");

                                document.getElementById("idRepre").value = rep.id;
                                document.getElementById("selectEmpresa").value = rep.id_empresa;
                                document.getElementById("rutRepre").value = formatearRut(rep.rut_repre);
                                document.getElementById("repreLegal").value = rep.repre_legal;

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

        function ingresarRepresentante(e) {
            e.preventDefault();
            
            const selectEmpresa = document.getElementById("selectEmpresa").value;
            const rutRepre = document.getElementById("rutRepre").value;
            const repreLegal = document.getElementById("repreLegal").value;

            const campos = ["selectEmpresa", "rutRepre", "repreLegal"];

            const camposVacios = campos.some(campo => document.getElementById(campo).value.trim() === "");
                
            if(camposVacios) {
                mostrarAlerta("Por favor completa todos los campos", "error");
                return;
            }

            if(!validarRut(rutRepre)) {
                mostrarAlerta("El RUT ingresado no es válido", "error");
                return;
            }

            const representanteData = {
                empresa: selectEmpresa,
                rutRepre: rutRepre,
                repreLegal: repreLegal
            };

            const idRepre = document.getElementById("idRepre").value;

            const urlBase = "{{ url('representantes') }}";

            let url, action;

            if(idRepre) {
                action = "PATCH";
                url = `${urlBase}/update/${idRepre}`;
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
                    body: JSON.stringify(representanteData)
                })
                .then(handleFetchErrors)
                .then(data => {
                    if (data.success) {
                        mostrarAlerta(data.message, "success");
                        limpiarFormulario();
                        listarRepresentantes();
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
                    // btnGuardar.disabled = false;
                });

        }

        function eliminarRepresentante(idRepre) {

            if (!confirm("¿Estás seguro de que deseas eliminar el representante?")) {
                return;
            }
            
            const url = `{{ url('representantes') }}/delete/${idRepre}`;
            
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
                    listarRepresentantes();
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
            document.getElementById("idRepre").value = "";
            document.getElementById("selectEmpresa").value = "";
            document.getElementById("rutRepre").value = "";
            document.getElementById("repreLegal").value = "";
            document.getElementById("textoGrabar").textContent = "Grabar";
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
            }, 3000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            cargarEmpresas();
            listarRepresentantes();
            document.getElementById("rutRepre").addEventListener("blur", function () {
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

            document.getElementById("formRepre").addEventListener("submit", ingresarRepresentante);
        });

    </script>

@endpush