<?php

namespace App\Http\Controllers;

use App\Models\If_Sol;
use App\Models\Indicador;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class IndicadorController extends Controller
{

    use ApiResponser;

    public function obtenerToken()
    {
        $response = Http::withOptions([
            'verify'=> false
        ])->post('https://postulaciones.solutoria.cl/api/acceso', [
            'userName' => 'matiasmanriquezortizkfqtc_oew@indeedemail.com',
            'flagJson' => true,
        ]);

        $body = $response->getBody();
        $json = json_decode($body);

        return $this->load($json->token);
    }

    public function load($token)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->withOptions([
            'verify'=> false
        ])->get('https://postulaciones.solutoria.cl/api/indicadores');

        $body = $response->getBody();
        $json = json_decode($body);
        
        foreach ($json as $indicador){
            $array = get_object_vars($indicador);
            if($array['codigoIndicador'] == "UF")
                DB::table('indicadors')->insert($array);
        }

        return $this->successResponse("", 'Carga completa');
    }

    //---- CRUD ----//

    public function getTableData()
    {
        $data = DB::table('indicadors')->paginate(6);
        return $data;
    }

    public function create(Request $request)
    {
        $ind = new Indicador();
        $ind->nombreIndicador = $request->nombreIndicador;
        $ind->codigoIndicador = $request->codigoIndicador;
        $ind->unidadMedidaIndicador = $request->unidadMedidaIndicador;
        $ind->valorIndicador = $request->valorIndicador;
        $ind->fechaIndicador = $request->fechaIndicador;
        $ind->save();
        return $this->successResponse("", 'Agregado exitosamente');
    }

    public function show(Request $request)
    {
        return Indicador::find($request->id);
    }

    public function edit(Request $request)
    {
        $ind = Indicador::find($request->id);
        $ind->nombreIndicador = $request->nombreIndicador ?? $ind->nombreIndicador;
        $ind->codigoIndicador = $request->codigoIndicador ?? $ind->codigoIndicador;
        $ind->unidadMedidaIndicador = $request->unidadMedidaIndicador ?? $ind->unidadMedidaIndicador;
        $ind->valorIndicador = $request->valorIndicador ?? $ind->valorIndicador;
        $ind->fechaIndicador = $request->fechaIndicador ?? $ind->fechaIndicador;
        $ind->save();
        return $this->successResponse('','Editado exitosamente');
    }

    public function destroy($id)
    {
        Indicador::destroy($id);
        return json_encode(['msg' => 'removed']);
    }

    // private function ingresarDatos($data, Indicador $ind = new Indicador())
    // {   
    //     $ind->publ_descripcion = $data["descripcion"] ?? $ind->publ_descripcion;
    //     $ind->publ_titulo = $data["titulo"] ?? $ind->publ_titulo;
    //     $ind->puca_id = $data["idPlubCat"] ?? $ind->puca_id;
    //     $ind->pues_id = $data["idPublEs"] ?? $ind->pues_id;
    //     $ind->usua_id =  $_SESSION['id'] ?? $ind->usua_id;
    //     $ind->save();  
    //     return $ind;
    // }
}
