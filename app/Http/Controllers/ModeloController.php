<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Validator;
use Response;
use DataTables;
use DB;
use Auth;
use App\Modelo;
use App\Marca;

class ModeloController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        return view('modelo.index', compact('marcas'));
    }

    public function list()
    {
        $modelo = Modelo::join('marcas','marcas.id','modelos.fk_marca')
        ->select('marcas.nome as nome_marca','modelos.nome as nome_modelo','modelos.fk_marca')
        ->orderBy('modelos.created_at', 'desc')
        ->get();
            
        return DataTables::of($modelo)
            ->editColumn('acoes', function ($modelo){
                return $this->setBtns($modelo);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Modelo $modelo){
        $dados = "data-id_del='$modelo->id' 
        data-id='$modelo->id' 
        data-nome='$modelo->nome_modelo' 
        data-fk_marca='$modelo->fk_marca' 
        ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver setor' $dados> <i class='fa fa-eye'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar setor' $dados><i class='fa fa-trash'></i></a>";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar setor' $dados> <i class='fa fa-edit'></i></a> ";


        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {  
        $rules = array(
            'fk_marca' => 'required',          
            'nome' => 'required'           
        );
        $attributeNames = array(
            'fk_marca' => 'marca',
            'nome' => 'Nome'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $modelo = new Modelo();
            $modelo->fk_marca = $request->fk_marca;
            $modelo->nome = $request->nome;
            $modelo->save();

            return response()->json($modelo);
        }
    }

    public function update(Request $request)
    {
        $rules = array(      
            'nome' => 'required'           
        );
        $attributeNames = array(
            'nome' => 'Nome'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

        $modelo = Modelo::find($request->id);
        $modelo->nome = $request->nome;
        $modelo->fk_marca = $request->fk_marca;
        $modelo->save();
      
        return response()->json($modelo);

        }
    }

    public function destroy(Request $request)
    {
        $modelo = Modelo::destroy($request->id_del);

        return response()->json($modelo);
    }
}
