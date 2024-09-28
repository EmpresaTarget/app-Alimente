<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoadorModel;

class DoadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doadores = DoadorModel::all();

        foreach($doadores as $d){
            /*echo $d->idDoador;
            echo $d->nomeDoador;
            echo $d->emailDoador;
            echo $d->senhaDoador;
            echo $d->fotoDoador;
            echo $d->quantidadeDoacoes;
            echo $d->quantidadeOngsSeguidas;
            echo $d->quantidadeCurtidasDoador;
            echo $d->enderecoDoador;
            echo $d->numeroDoador;
            echo $d->complementoDoador;
            echo $d->cepDoador;
            echo $d->bairroDoador;
            echo $d->cidadeDoador;
            echo $d->estadoDoador;
            echo $d->causasPreferidasDoador;
            echo $d->dataCadastroDoador;
            echo $d->denunciasRealizadasDoador;*/
        }
    }

    public function exibirDoadores(){
        $doadores = DoadorModel::all();

        //$doadores = DoadorModel::where('idDoador',1)->get();

        //$doadores = DoadorModel::where('idDoador', '<=', 2)->get();

        //$doadores = DoadorModel::where('idDoador', '>=', 1)->orderBy('nomeDoador', 'asc')->get();

        //$doadores = DoadorModel::where('nomeDoador', 'paulo')->get();
        //return view('doadoresView', compact('doadores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/cadastrodoador');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doador = new DoadorModel();

        $doador->nomeDoador = $request->nomeDoador; 
        $doador->emailDoador = $request->emailDoador;
        $doador->senhaDoador = $request->senhaDoador;
        $doador->cepDoador = $request->cepDoador; 
        $doador->enderecoDoador = $request->enderecoDoador; 
        $doador->complementoDoador = $request->complementoDoador; 
        $doador->bairroDoador = $request->bairroDoador; 
        $doador->cidadeDoador = $request->cidadeDoador; 
        $doador->estadoDoador = $request->estadoDoador;
        $doador->save();

        if ($request->has('causas') && is_array($request->causas)) {
            foreach ($request->causas as $causa) {
                // Cria uma nova entrada na tabela causasdoador
                $causaDoador = new CausaDoadorModel();
                $causaDoador->idDoador = $doador->idDoador; // Relaciona ao doador recém-criado
                $causaDoador->causa = $causa; // Define a causa
                $causaDoador->save(); // Salva no banco de dados
            }
        }

        return redirect()->route('criar.perfil', ['id' => $doador->idDoador]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function createProfile($id)
    {

         // Busca o doador pelo ID
    $doador = DoadorModel::find($id);

    // Verifica se o doador existe
    if (!$doador) {
        return redirect()->back()->with('error', 'Doador não encontrado.');
    }

        // Passa o ID do doador para a view do perfil
        return view('criarperfildoador', ['doador' => $doador, 'id' => $id]);
    }

    public function storeProfile(Request $request, $id)
    {
        $doador = DoadorModel::find($id); // Use $id para encontrar o doador
        
        if ($doador) {
            // Atualiza os dados do doador com as informações do perfil
            $doador->nomeUsuarioDoador = $request->nomeUsuarioDoador; 
            $doador->biografiaDoador = $request->biografiaDoador; 
            $doador->fotoDoador = $request->fotoDoador; // Certifique-se de que está tratando upload de arquivo corretamente
            $doador->save();
    
            // Se houver causas, salve-as na tabela separada
            if ($request->has('causas') && is_array($request->causas)) {
                foreach ($request->causas as $causa) {
                    $causaDoador = new CausaDoadorModel();
                    $causaDoador->idDoador = $doador->idDoador;
                    $causaDoador->causa = $causa;
                    $causaDoador->save();
                }
            }
        }
    
        return redirect()->route('/'); // Redireciona para a página principal ou para outra rota
    }
    

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doadores = DoadorModel::where('idDoador', $id)->delete();
        return redirect()->action('App\http\Controllers\DoadorController@exibirDoadores');
    }
}
