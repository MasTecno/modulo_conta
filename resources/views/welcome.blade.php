@extends("layouts.app")

@section("titulo")
    Modulo Contabilidad
@endsection

@section("navBarConta")
    <x-conta-navbar />
@endsection

@section("contenido")
    
    <div class="flex justify-end p-6 pt-2">
        <a class="p-1.5 w-25 text-center bg-slate-600 text-white border border-slate-600 rounded-md mt-4" href="http://127.0.0.1:8000/dashboard">Menu</a>
    </div>
  
    <p>Hola mundo</p>
@endsection