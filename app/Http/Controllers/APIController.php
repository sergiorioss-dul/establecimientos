<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\Categoria;
use App\Establecimiento;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //Metodo para obtener categorias
    public function categorias()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
    //Muestra establecimientos
    public function categoria(Categoria $categoria)
    {
        $establecimientos = Establecimiento::where('categoria_id',$categoria->id)->with('categoria')->take(3)->get();
        return response()->json($establecimientos);     
    }
    public function show(Establecimiento $establecimiento)
    {
        $imagenes = Imagen::where('id_establecimiento',$establecimiento->uuid)->get();
        $establecimiento->imagenes = $imagenes;
        return response()->json($establecimiento);
    }
    public function index()
    {
        $establecimientos = Establecimiento::with('categoria')->get();
        return response()->json($establecimientos);
    }
    public function establecimientoscategoria( Categoria $categoria)
    {
        $establecimientos = Establecimiento::where('categoria_id',$categoria->id)->with('categoria')->get();
        return response()->json($establecimientos);   
    }

}
