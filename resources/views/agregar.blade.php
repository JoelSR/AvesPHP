@extends('layouts.app')
@section('title', 'Agregar ave')

@if (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

@section('content')

<div class="container">
  <h1>Agregar Ave</h1>

  <form method="POST" action="{{ route('aves.guardar') }}">
    @csrf
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="form-group">
      <label for="nombre_ingles">Nombre en inglés</label>
      <input type="text" class="form-control" id="nombre_ingles" name="nombre_ingles">
    </div>
    <div class="form-group">
      <label for="nombre_latin">Nombre científico</label>
      <input type="text" class="form-control" id="nombre_latin" name="nombre_latin" required>
    </div>
    <div class="form-group">
      <label for="url">Url imagen</label>
      <input type="text" class="form-control" id="url" name="url" required>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Agregar</button>
  </form>
</div>

@endsection
