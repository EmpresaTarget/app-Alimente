<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\PrestacaoConta;
use App\Models\Campanha;
use App\Models\Postagem;
use App\Models\Doacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeedOngController extends Controller
{
    
    public function index()
{
    if (Auth::check() && Auth::user()->idOng) {
        $ongId = Auth::user()->idOng;

        // Recupera a ONG associada ao usuário autenticado
        $ong = Ong::find($ongId);

        // Busca campanhas associadas a essa ONG
        $campanhas = Campanha::where('idOng', $ongId)->get();
        $postagens = Postagem::where('idOng', $ongId)->get();

        $campanhasCount = Campanha::where('idOng', $ongId)->count();
        $postagensCount = Postagem::where('idOng', $ongId)->count();

        return view('feedOng', compact('campanhas', 'postagens', 'postagensCount', 'campanhasCount', 'ong'));
    } else {
        return redirect()->route('logindoador')->withErrors('Você precisa estar logado para ver suas postagens.');
    }
}

public function dashboard()
{
    if (Auth::check() && Auth::user()->idOng) {
        $ongId = Auth::user()->idOng;

        // Recupera a ONG associada ao usuário autenticado
        $ong = Ong::find($ongId);

        // Busca campanhas associadas a essa ONG
        $campanhas = Campanha::where('idOng', $ongId)->get();
        $postagens = Postagem::where('idOng', $ongId)->get();

        $campanhasCount = Campanha::where('idOng', $ongId)->count();

         // Contagem das campanhas em andamento e finalizadas
         $campanhasEmAndamento = $campanhas->filter(function ($campanha) {
            $dataAtual = now();  // Data atual
            return $dataAtual->between($campanha->dataInicioCampanha, $campanha->dataFimCampanha);
        });

        $campanhasFinalizadas = $campanhas->filter(function ($campanha) {
            $dataAtual = now();  // Data atual
            return $dataAtual->greaterThan($campanha->dataFimCampanha);
        });

        $campanhasCount = $campanhas->count();
        $campanhasEmAndamentoCount = $campanhasEmAndamento->count();
        $campanhasFinalizadasCount = $campanhasFinalizadas->count();

        $postagensCount = Postagem::where('idOng', $ongId)->count();
        $totalCurtidas = $postagens->sum('numeroCurtidas');
        $totalArrecadado = Doacao::where('ongId', $ongId)->sum('valor');
        $doacoesPorMes = Doacao::where('ongId', $ongId)
        ->selectRaw('mes, count(idDoacao) as total_doacoes')
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        $campanhasFinalizadasCount = Campanha::where('idOng', $ongId)
        ->where('dataFimCampanha', '<', now())
        ->count();

$contasPrestadasCount = PrestacaoConta::where('idOng', $ongId)->count();

// Calcular as contas pendentes
$contasPendentesCount = $campanhasFinalizadasCount - $contasPrestadasCount;

// Garantir que a porcentagem não seja negativa
$porcentagemContasPrestadas = 100 - ($contasPendentesCount * 10);

// A porcentagem não deve ser menor que 0
if ($porcentagemContasPrestadas < 0) {
$porcentagemContasPrestadas = 0;
}       
        
            // Formatar os dados para o JavaScript
        $doacoesPorMes = $doacoesPorMes->map(function ($doacao) {
            return [
                'mes' => $doacao->mes,
                'total_doacoes' => $doacao->total_doacoes
            ];
        });

        return view('dashOng', compact('campanhas', 'postagensCount', 'campanhasCount', 'ong', 'totalCurtidas', 'totalArrecadado', 'doacoesPorMes', 'campanhasEmAndamentoCount', 'campanhasFinalizadasCount', 'porcentagemContasPrestadas'));
    } else {
        return redirect()->route('logindoador')->withErrors('Você precisa estar logado para ver suas postagens.');
    }
}

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'nomeCampanha' => 'required|string|max:100',
            'assuntoCampanha' => 'nullable|string|max:255',
            'descricaoCampanha' => 'required|string',
            'imagemCampanha' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dataInicioCampanha' => 'nullable|date',
            'dataFimCampanha' => 'nullable|date',
            'chavePix' => 'nullable|string|max:255',
        ]);
    
        // Verifica se a campanha pertence à ONG autenticada
        $campanha = Campanha::where('idOng', Auth::user()->idOng)->find($id);
    
        if (!$campanha) {
            return response()->json(['error' => 'Campanha não encontrada ou não pertence à sua ONG'], 404);
        }
    
        // Atualiza os dados da campanha
        $campanha->fill($request->except('imagemCampanha'));
    
        if ($request->hasFile('imagemCampanha')) {
            // Exclui a imagem antiga, se existir
            if ($campanha->imagemCampanha) {
                Storage::disk('public')->delete($campanha->imagemCampanha);
            }
            // Armazena a nova imagem
            $campanha->imagemCampanha = $request->file('imagemCampanha')->store('campanhas', 'public');
        }
    
        $campanha->save();
    
        return response()->json([
            'idCampanha' => $campanha->idCampanha,
            'nomeCampanha' => $campanha->nomeCampanha,
            'assuntoCampanha' => $campanha->assuntoCampanha,
            'descricaoCampanha' => $campanha->descricaoCampanha,
            'imagemCampanha' => $campanha->imagemCampanha,
            'chavePix' => $campanha->chavePix,
        ]);
    }

    public function show($id)
    {
        $campanha = Campanha::find($id);
        if (!$campanha) {
            return response()->json(['error' => 'Campanha não encontrada'], 404);
        }
        return response()->json($campanha);
    }    
    
    public function destroy($id)
    {
        // Verifica se a campanha pertence à ONG autenticada
        $campanha = Campanha::where('idOng', Auth::user()->idOng)->find($id);
    
        if (!$campanha) {
            return response()->json(['error' => 'Campanha não encontrada ou não pertence à sua ONG'], 404);
        }
    
        // Exclui a campanha
        $campanha->delete();
    
        return response()->json(['message' => 'Campanha excluída com sucesso!']);
    }    

}
    

