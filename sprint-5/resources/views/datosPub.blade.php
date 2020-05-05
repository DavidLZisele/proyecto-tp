@extends('layouts.head')

@section('title')
    Modificar Publicacion
@endsection
    

@section('content')

    <div class="container col-12 contenedor-modpub">
            <div class="div-volver-perfil">
                <a href="{{route('categoria.index')}}" class="volver">
                    <i class="fa fa-sign-out" aria-hidden="true" style="transform:rotateY(180deg);font-size:20px;display:block"></i>
                </a>
            </div>
            <form action="{{route('datos.updatePos',$posteo)}}" method = "POST" enctype="multipart/form-data" class="col-8 col-md-6 col-lg-4" id="form-actPos">
                @csrf 
                @method('PUT') 
                 <div>
                    <input type="text" name="contenido" id="contenido" value="{{$posteo->descripcion}}" class="col-12 contenido-posteo">
                </div>
                <div class="div-foto-modificarpub">
                    <span>
                        FOTO
                    </span>
                    <input type="file" name="fotopub" id="foto-pub">
                </div>
                <button type="submit">Aceptar</button>
            </form>
    </div>
    <script>
        window.onload = function()
        {
            document.getElementById('form-actPos').onsubmit = function(event)
            {
                let inputs = Array.from(this.elements);
                inputs.pop();
                inputs.shift();
                let resp = false;
            for(let input of inputs)
            {
                if(input.getAttribute('name')=="contenido")
                 {
                     if(input.value == "")
                    {
                        resp = true;
                        break;
                    }
                 }
            }
            if(resp)
            {
                 event.preventDefault();
                 toastr.error('Campo vacio');
             }
           }
        }
    </script>
@endsection