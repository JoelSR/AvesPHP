@extends('layouts.app')

@section('title', 'Aves')

@section('content')

<div class="container-fluid">
    <div class="col-md-5 mx-auto">
        <div class="form-group row">
            <label for="fecha-inicio" class="col-sm-2 col-form-label">Fecha inicio:</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="fecha-inicio">
            </div>
        </div>
        <div class="form-group row">
            <label for="fecha-fin" class="col-sm-2 col-form-label">Fecha fin:</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="fecha-fin">
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="btn-filtrar">Filtrar</button>
    </div>
    <table class="table table-hover tablesorter" id="tabla-aves">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Nombre en inglés</th>
                <th>Nombre científico</th>
                <th>URL</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aves ?? '' as $ave)
                <tr>
                    <td id='ave-id'>{{ $ave->id }}</td>
                    <td>{{ $ave->nombre }}</td>
                    <td>{{ $ave->nombre_ingles }}</td>
                    <td>{{ $ave->nombre_latin }}</td>
                    <td>{{ $ave->url }}</td>
                    <td>{{ $ave->fecha_registro }}</td>
                    <td>
                        <button type="button" class="btn btn-primary update-button" onclick="window.location.href='{{ route('aves.actualizar', $ave->id) }}'">Editar</button>
                        <button type="button" class="btn btn-danger delete-button" data-ave-id="{{ $ave->id }}">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!--BORRAR AVE-->
<script>
    $('.delete-button').on('click', function() {
        const aveId = $(this).data('ave-id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/listar/' + aveId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(result) {
                window.location.href = '/listar';
            },
            error: function(xhr, status, error) {
                alert('Error al borrar la ave');
            }
        });
    });
</script>

<!--TABLE SORTER para ordenar los elementos de la tabla de aves-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
<script>
    $(document).ready(function() {
        $("table").tablesorter();
    });
</script>

<script>
    $(document).ready(function() {
        $('#btn-filtrar').click(function() {
            var fechaInicio = $('#fecha-inicio').val();
            var fechaFin = $('#fecha-fin').val();
            $.get('{{ route('aves.filtrar') }}', {
                'fecha-inicio': fechaInicio,
                'fecha-fin': fechaFin
            }).done(function(response) {
                // Encuentra la tabla en el DOM
                var table = $('table.table-hover tbody');

                // Limpia el contenido actual de la tabla
                table.empty();

                // Cambiar la tabla
                $.each(response, function(index, ave) {
                    var row = $('<tr>');
                    row.append($('<td>').text(ave.id));
                    row.append($('<td>').text(ave.nombre));
                    row.append($('<td>').text(ave.nombre_ingles));
                    row.append($('<td>').text(ave.nombre_latin));
                    row.append($('<td>').text(ave.url));
                    row.append($('<td>').text(ave.fecha_registro));
                    row.append($('<td>').html('<button type="button" class="btn btn-primary update-button" onclick="window.location.href=' + "'aves.actualizar/" + ave.id + "'" + '">Editar</button>' + '<button type="button" class="btn btn-danger delete-button" data-ave-id="' + ave.id + '">Eliminar</button>'));
                    table.append(row);
                });
                $("table").trigger("updateAll");
            });
        });
    });
</script>

@endsection