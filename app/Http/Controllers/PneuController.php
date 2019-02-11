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
use App\Pneu;
use App\Marca;

class PneuController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        return view('pneu.index', compact('marcas'));
    }

    public function list()
    {
        $modelo = Pneu::join('modelos','modelos.id','pneus.fk_modelo')
        ->join('marcas','marcas.id','modelos.fk_marca')
        ->select('marcas.id as fk_marca','modelos.id as fk_modelo','marcas.nome as nome_marca','modelos.nome as nome_modelo','modelos.fk_marca','pneus.id','pneus.raio','pneus.largura',
            'pneus.perfil')
        ->orderBy('pneus.created_at', 'desc')
        ->where('pneus.status',1)
        ->get();
            
        return DataTables::of($modelo)
            ->editColumn('acoes', function ($modelo){
                return $this->setBtns($modelo);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Pneu $pneu){
        $dados = "data-id_del='$pneu->id' 
        data-id='$pneu->id' 
        data-perfil='$pneu->perfil' 
        data-fk_marca='$pneu->fk_marca' 
        data-fk_modelo='$pneu->fk_modelo' 
        data-raio='$pneu->raio' 
        data-largura='$pneu->largura' 
        ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver setor' $dados> <i class='fa fa-eye'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar setor' $dados><i class='fa fa-trash'></i></a>";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar setor' $dados> <i class='fa fa-edit'></i></a> ";


        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {  
        $rules = array(      
            'largura' => 'required|numeric|min:100|max:200',           
            'perfil' => 'required|numeric|min:10|max:80',           
            'raio' => 'required',           
            'fk_marca' => 'required',           
            'fk_modelo' => 'required',           
        );
        $attributeNames = array(
            'largura' => 'Largura',
            'perfil' => 'Perfil',
            'raio' => 'Raio',
            'fk_marca' => 'Marca',
            'fk_modelo' => 'Modelo',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $pneu = new Pneu();
            $pneu->fk_marca = $request->fk_marca;
            $pneu->fk_modelo = $request->fk_modelo;
            $pneu->raio = $request->raio;
            $pneu->largura = $request->largura;
            $pneu->perfil = $request->perfil;
            $pneu->status = 1;
            $pneu->save();

            return response()->json($pneu);
        }
    }

    public function update(Request $request)
    {
        $rules = array(      
            'largura' => 'required|numeric|min:100|max:200',           
            'perfil' => 'required|numeric|min:10|max:80',           
            'raio' => 'required',           
            'fk_marca' => 'required',           
            'fk_modelo' => 'required',           
        );
        $attributeNames = array(
            'largura' => 'Largura',
            'perfil' => 'Perfil',
            'raio' => 'Raio',
            'fk_marca' => 'Marca',
            'fk_modelo' => 'Modelo',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

        $pneu = Pneu::find($request->id);
        $pneu->fk_marca = $request->fk_marca;
        $pneu->fk_modelo = $request->fk_modelo;
        $pneu->raio = $request->raio;
        $pneu->largura = $request->largura;
        $pneu->perfil = $request->perfil;
        $pneu->save();
      
        return response()->json($pneu);

        }
    }

    public function destroy(Request $request)
    {
        $pneu = Pneu::find($request->id_del);
        $pneu->status = '0';
        $pneu->save();

        return response()->json($pneu);
    }
}
