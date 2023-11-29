<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipioController extends Controller
{
    public function index()
    {
        $estados = DB::table('estados')->get();

        $municipios = [];

        return view('selecionar_municipio', compact('estados', 'municipios'));
    }

    public function getMunicipios(Request $request)
    {
       // Obter os municípios do estado selecionado
    $estadoId = $request->input('estado_id');
    $estadoSigla = DB::table('estados')->where('id', $estadoId)->value('uf');
    $municipios = DB::table('municipios')->where('estado', $estadoId)->get();

    // Incluir a sigla do estado aos dados dos municípios
    foreach ($municipios as $municipio) {
        $municipio->uf = $estadoSigla;
        $municipio->ibge = DB::table('municipios')->where('id', $municipio->id)->value('ibge');
    }

    return response()->json($municipios);
    }
}
