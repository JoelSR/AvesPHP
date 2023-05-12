@extends('layouts.app')
@section('title', 'Editar ave')

@if (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

@section('content')

<div class="container">
  <h1>Editar Ave</h1>

  <form method="POST" action="{{ route('aves.update', $ave->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $ave->nombre }}" required>
    </div>
    <div class="form-group">
      <label for="nombre_ingles">Nombre en inglés</label>
      <input type="text" class="form-control" id="nombre_ingles" name="nombre_ingles" value="{{ $ave->nombre_ingles }}">
    </div>
    <div class="form-group">
      <label for="nombre_latin">Nombre científico</label>
      <input type="text" class="form-control" id="nombre_latin" name="nombre_latin" value="{{ $ave->nombre_latin }}" required>
    </div>
    <div class="form-group">
      <label for="url">Url imagen</label>
      <input type="text" class="form-control" id="url" name="url" value="{{ $ave->url }}" required>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Actualizar</button>
  </form>
</div>

@endsection
