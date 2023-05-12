@extends('layouts.app')

@section('title', 'Aves')

@section('content')

<div class="container-fluid">
    <div class="col-md-1">
        <ul class="list-group list-inline list-group-horizontal">
            <li class="list-group-item active">Filtrar</li>
            <li class="list-group-item"><a href="#" class="filtrar-letra" data-letra="all">Todos</a></li>
            @foreach(range('A', 'Z') as $letra)
                <li class="list-group-item"><a href="#" class="filtrar-letra" data-letra="{{ $letra }}">{{ $letra }}</a></li>
            @endforeach
        </ul>
    </div>
    <br>
    <div class="row">
        <div>
            <div class="row" id="aves-container">
                @foreach ($aves ?? '' as $ave)
                    <div class="col-md-4">
                        <div class="card">
                            <h3 class="card-title text-md-center border-bottom">{{ $ave->nombre }}</h3>
                            <img src="{{ $ave->url }}" alt="{{ $ave->nombre }}">
                            <div class="card-body">        
                                <p>
                                    <strong>Nombre en inglés:</strong>{{ $ave->nombre_ingles }}<br>
                                    <strong>Nombre científico:</strong>{{ $ave->nombre_latin }}<br>
                                    <strong>Fecha de registro:</strong>{{ $ave->fecha_registro }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.list-inline a').click(function(e) {
            e.preventDefault();
            var letra = $(this).data('letra');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('aves.filtrarLetra') }}",
                type: "GET",
                data: {
                    letra_inicial: letra
                },
                headers: {
                'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#aves-container').empty();
                    $('#aves-container').html(response);
                },
                error: function(xhr, status, error) {
                    alert('Error al filtrar'+' '+error+' '+status);
                }
            });
        });
    });
</script>
@endsection