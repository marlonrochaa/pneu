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
use App\Marca;

class MarcaController extends Controller
{
    public function index()
    {
        return view('marca.index');
    }

    public function list()
    {
        $marca = Marca::orderBy('created_at', 'desc')
        ->get();
            
        return DataTables::of($marca)
            ->addColumn('imagem', function ($marca){
                 $url = asset($marca->imagem);
                 return '<img src='.$url.' width="150px"  />';
            })
            ->editColumn('acoes', function ($marca){
                return $this->setBtns($marca);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Marca $marca){
        $dados = "data-id_del='$marca->id' 
        data-id='$marca->id' 
        data-nome='$marca->nome' 
        ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver setor' $dados> <i class='fa fa-eye'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar setor' $dados><i class='fa fa-trash'></i></a>";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar setor' $dados> <i class='fa fa-edit'></i></a> ";


        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {  
        $rules = array(
            'imagem' => 'required',          
            'nome' => 'required'           
        );
        $attributeNames = array(
            'imagem' => 'imagem',
            'nome' => 'Nome'
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
        	$imagem = $request->file('imagem')->store('public/imagens/banners');
            $imagem = str_replace('public','storage',$imagem);

            $marca = new Marca();
            $marca->imagem = $imagem;
            $marca->nome = $request->nome;
            $marca->save();

            return response()->json($marca);
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

        $marca = Marca::find($request->id);
        if($request->file('imagem')){
        $imagem = $request->file('imagem')->store('public/imagens/banners');
            $imagem = str_replace('public','storage',$imagem);
            $marca->imagem = $imagem;
        }
        $marca->nome = $request->nome;
        $marca->save();
      
        return response()->json($marca);

        }
    }

    public function modelos($id)
    {
        $marca = Marca::find($id)->modelos()->get();

        return response()->json($marca);
    }

    public function destroy(Request $request)
    {
        $marca = Marca::destroy($request->id_del);

        return response()->json($marca);
    }
}











