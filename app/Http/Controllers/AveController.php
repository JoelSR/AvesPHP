<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ave;
use Illuminate\Support\Facades\Session;
use \Illuminate\Http\Response;

class AveController extends Controller
{
    public function index() {

        if (Ave::count() > 0) {
            $aves = Ave::all();
            return view('aves', compact('aves'));
        }

        //Fechas random para evitar 01-01-2020
        $min = 2020;
        $max = 2023;

        $data = file_get_contents(public_path('registros.http'));
        $json = substr($data, strpos($data, '['));
        $data = json_decode($json, true);

        // Recorrer los datos y guardarlos en la base de datos
        foreach ($data as $ave) {
            // fecha y hora
            $timestamp = mktime(rand(0, 23), rand(0, 59), rand(0, 59), rand(1, 12), rand(1, 28), rand($min, $max));
            // formato
            $formattedDate = date('Y-m-d H:i:s', $timestamp);
            Ave::updateOrCreate(
                ['nombre' => $ave['nombre']],
                [
                    'nombre_ingles' => $ave['nombreIngles'],
                    'nombre_latin' => $ave['nombreLatin'],
                    'url' => $ave['url'],
                    'fecha_registro' => $formattedDate,
                ]
            );
        }

        // Obtener todas las aves de la base de datos
        $aves = Ave::all();

        // Devolver una vista con las aves
        return view('aves', compact('aves'));
    }

    // formulario para agregar ave.

    public function create() {
        return view('agregar');
    }

    public function listar(Request $request) {
        $aves = Ave::query();
    
        // Verificar si se ha seleccionado una columna para ordenar
        if ($request->has('sortby')) {
            $columna = $request->input('sortby');
            $orden = $request->input('order', 'desc');

            // Aplicar ordenamiento
            $aves->orderBy($columna, $orden);
        }
    
        $aves = $aves->get();
        return view('listar', compact('aves'));
    }
    

    //almacenar ave.

    public function guardar(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_ingles' => 'required|string|max:255',
            'nombre_latin' => 'required|string|max:255|unique:aves',
            'url' => 'required|url|max:255',
            'fecha_registro' => 'nullable|date',
        ]);

        try {
            $ave = new Ave();
            $ave->nombre = $request->input('nombre');
            $ave->nombre_ingles = $request->input('nombre_ingles');
            $ave->nombre_latin = $request->input('nombre_latin');
            $ave->url = $request->input('url');
            $ave->fecha_registro = now();
            $ave->save();
    
            return redirect()->route('aves.aves');
        } catch (QueryException $e) {
            Session::flash('error', 'El ave ya existe en la base de datos.');
            return redirect()->back();
        }
    }

    //
    public function delete($id) {
        $ave = Ave::find($id);
        if (!$ave) {
            return response()->json(['message' => 'Ave no encontrada'], 404);
        }
        
        $ave->delete();
        return response()->json(['message' => 'Ave eliminada correctamente'], 204);
    }

    // Obtener los datos para la vista de edicion
    public function actualizar($id) {
        $ave = Ave::find($id);
        if (!$ave) {
            return response()->json(['message' => 'Ave no encontrada'], 404);
        }
        return view('editar', compact('ave'));
    }

    // Actualizar ave
    public function update(Request $request, $id) {
        
        $ave = Ave::find($id);
        if (!$ave) {
            return response()->json(['message' => 'Ave no encontrada'], 404);
        }
    
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'nombre_ingles' => 'required|string|max:255',
            'nombre_latin' => 'required|string|max:255|unique:aves,nombre_latin,'.$id,
            'url' => 'required|url|max:255',
            'fecha_registro' => 'nullable|date',
        ]);
    
        try {
            $ave->update($validatedData);
    
            return redirect()->route('aves.aves')->with('success', 'Ave actualizada correctamente.');
        } catch (QueryException $e) {
            Session::flash('error', 'No se pudo actualizar.');
            return redirect()->back();
        }
    }    

    // Filtrar por fecha
    public function filtrar(Request $request) {
        $fechaInicio = $request->input('fecha-inicio');
        $fechaFin = $request->input('fecha-fin');
        
        $aves = Ave::whereBetween('fecha_registro', [$fechaInicio, $fechaFin])->get();
        
        return response()->json($aves);
    }

    // Filtrar por letra inicial
    public function filtrarPorLetra(Request $request) {
        $letraInicial = $request->input('letra_inicial');
    
        if ($letraInicial === 'all') {
            // consulta para obtener todas las aves
            $aves = Ave::all();
    
        } else {
            // consulta para filtrar por letra inicial
            $aves = Ave::where('nombre', 'LIKE', $letraInicial . '%')->get();
        }
    
        // generar el HTML de las cards de aves
        $avesHtml = '';
        foreach ($aves as $ave) {
            $avesHtml .= '<div class="col-md-4">';
            $avesHtml .= '<div class="card">';
            $avesHtml .= '<h3 class="card-title text-md-center border-bottom">' . $ave->nombre . '</h3>';
            $avesHtml .= '<img src="' . $ave->url . '" alt="' . $ave->nombre . '">';
            $avesHtml .= '<div class="card-body">';
            $avesHtml .= '<p><strong>Nombre en inglés:</strong>' . $ave->nombre_ingles . '<br>';
            $avesHtml .= '<strong>Nombre científico:</strong>' . $ave->nombre_latin . '<br>';
            $avesHtml .= '<strong>Fecha de registro:</strong>' . $ave->fecha_registro . '</p>';
            $avesHtml .= '<br>';
            $avesHtml .= '</div></div></div>';
        }
    
        // devolver el HTML de las cards de aves
        return $avesHtml;
    }
    


}
