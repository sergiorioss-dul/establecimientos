@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
    integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
    crossorigin="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.css" integrity="sha256-NkyhTCRnLQ7iMv7F3TQWjVq25kLnjhbKEVPqGJBcCUg=" crossorigin="anonymous" />
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mt-4">Registrar Establecimiento</h1>
        <div class="mt-5 row justify-content-center">
            <form
                class="col-md-9 col-xs-12 card card-body"
                action="{{ route('establecimiento.store')}}"
                method="POST"
                enctype="multipart/form-data"
            >
            @csrf
                <fieldset class="border p-4">
                    <legend class="text-primary">Nombre,Categoría e Imagen Principal</legend>
                    <div class="form-group">
                        <label for="nombre">Nombre Establecimiento</label>
                        <input name="nombre" placeholder="Nombre Establecimiento" type="text" id="nombre" class="form-control
                                    @error('nombre') is-invalid @enderror" value={{ old('nombre') }}>
                        @error('nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <select class="form-control @error('categoria_id') is-invalid @enderror" name="categoria_id"
                            id="categoria">
                            <option value="" selected disabled>--Seleccione--</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id') === $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input name="imagen_principal" type="file" id="imagen_principal" class="form-control
                                    @error('imagen_principal') is-invalid @enderror" value={{ old('imagen_principal') }}>
                        @error('imagen_principal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </fieldset>



                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Ubicación</legend>
                    <div class="form-group">
                        <label for="formbuscador">Coloca la dirección del Establecimiento</label>
                        <input placeholder="Calle del Establecimiento" type="text" id="formbuscador" class="form-control">
                        <p class="text-secondary mt-5 mb-3 text-center">
                            El asistente colocará una dirección estimada o mueve el PIN al lugar correcto
                        </p>
                    </div>
                    <div class="form-group">
                        <div id="map" style="height: 400px;"></div>
                        <p class="informacion">Confirma que los siguientes campos son correctos</p>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input 
                                class="form-control @error('direccion') is-invalid @enderror"
                                type="text"
                                placeholder="Dirección" 
                                id="direccion"
                                name="direccion"
                                value="{{old('direccion')}}"
                            >
                            @error('direccion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input 
                                class="form-control @error('direccion') is-invalid @enderror"
                                type="text"
                                name="colonia"
                                placeholder="Colonia" 
                                id="colonia"
                                value="{{old('colonia')}}"
                            >
                            @error('colonia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" name="lat" id="lat" value="{{old('lat')}}">
                        <input type="hidden" name="lng" id="lng" value="{{old('lng')}}">
                    </div>
                    
                </fieldset>
                <fieldset class="border p-4 mt-5">
                    <legend  class="text-primary">Información Establecimiento: </legend>
                        <div class="form-group">
                            <label for="nombre">Teléfono</label>
                            <input 
                                type="tel" 
                                class="form-control @error('telefono')  is-invalid  @enderror" 
                                id="telefono" 
                                placeholder="Teléfono Establecimiento"
                                name="telefono"
                                value="{{ old('telefono') }}"
                            >
    
                                @error('telefono')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="nombre">Descripción</label>
                            <textarea
                                class="form-control  @error('descripcion')  is-invalid  @enderror" 
                                name="descripcion"
                            >{{ old('descripcion') }}</textarea>
    
                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                        </div>
    
                        <div class="form-group">
                            <label for="nombre">Hora Apertura:</label>
                            <input 
                                type="time" 
                                class="form-control @error('apertura')  is-invalid  @enderror" 
                                id="apertura" 
                                name="apertura"
                                value="{{ old('apertura') }}"
                            >
                            @error('apertura')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label for="nombre">Hora Cierre:</label>
                            <input 
                                type="time" 
                                class="form-control @error('cierre')  is-invalid  @enderror" 
                                id="cierre" 
                                name="cierre"
                                value="{{ old('cierre') }}"
                            >
                            @error('cierre')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                </fieldset>
                <fieldset class="border p-4 mt-5">
                    <legend  class="text-primary">Imagenes Establecimiento: </legend>
                        <div class="form-group">
                            <label for="imagenes">Imagenes</label>
                            <div id="dropzone" class="dropzone form-control"></div>
                        </div>
                </fieldset>
                <input type="hidden" id="uuid" name="uuid" value="{{ Str::uuid()->toString() }}">
                <input type="submit" class="btn btn-primary mt-3 d-block" value="Registrar Establecimiento">
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/esri-leaflet@2.5.0/dist/esri-leaflet.js"
    integrity="sha512-ucw7Grpc+iEQZa711gcjgMBnmd9qju1CICsRaryvX7HJklK0pGl/prxKvtHwpgm5ZHdvAil7YPxI1oWPOWK3UQ=="
    crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
    integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
    crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.js" integrity="sha256-OG/103wXh6XINV06JTPspzNgKNa/jnP1LjPP5Y3XQDY=" crossorigin="anonymous" defer></script>
    @endsection



