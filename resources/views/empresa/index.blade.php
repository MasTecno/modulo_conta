@extends("layouts.app")

@section("titulo")

@endsection

@section("navBarConta")
    <x-conta-navbar />
@endsection

@section("contenido")
    
    <p>Empresa:  {{ session("empresaSeleccionada")->razon_social }}</p>

@endsection