@extends("layouts.app")

@section("titulo")

@endsection

@section("navBarConta")
    <x-conta-navbar :uuid="$empresa->uuid" />
@endsection

@section("contenido")
    
    {{-- <div class="flex justify-between items-center p-4">
        <p>Empresa:  {{ session("empresaSeleccionada")->razon_social }}</p>
        <a href="/conta" class="inline-flex items-center px-4 py-2 mr-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-200 font-medium text-sm">
            <i class="fa-solid fa-power-off mr-2"></i>
            Cambiar Empresa
        </a>
    </div> --}}
    
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white shadow-md">
        <div class="container mx-auto px-6 py-3.5">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">
                        <i class="fas fa-building mr-3"></i>
                        {{ session("empresaSeleccionada")->razon_social }}
                    </h1>
                </div>
                <div class="text-right">
                    @php
                        $usuario = session("usuario_autenticado");
                    @endphp  
                    <div>
                            <a href="/conta" class="inline-flex items-center px-4 py-2 mr-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-200 font-medium text-sm">
                                <i class="fa-solid fa-power-off mr-2"></i>
                                Cambiar Empresa
                            </a>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection