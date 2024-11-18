<?php

namespace App\Http\Controllers;

use App\Models\PrestacaoConta;
use App\Models\Campanha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestacaoContasController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $idOng = $user->idOng;
    
        // Recuperar campanhas finalizadas para essa ONG
        $campanhasFinalizadasCount = Campanha::where('idOng', $idOng)
                                             ->where('dataFimCampanha', '<', now())
                                             ->count();
    
        // Verificar quantas contas já foram prestadas pela ONG
        $contasPrestadasCount = PrestacaoConta::where('idOng', $idOng)->count();
    
        // Validar se a ONG não ultrapassou o número de contas a serem prestadas
        if ($contasPrestadasCount >= $campanhasFinalizadasCount) {
            return redirect()->back()->with('noPrestations', true);
        }
    
        // Validação dos arquivos
        $request->validate([
            'idOng' => 'required|exists:ong,idOng',
            'balanco' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'demonstracao' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receitas' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'despesas' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Armazenar os arquivos
        $balancoPath = $request->file('balanco')->store('prestacoes_contas');
        $demonstracaoPath = $request->file('demonstracao')->store('prestacoes_contas');
        $receitasPath = $request->file('receitas')->store('prestacoes_contas');
        $despesasPath = $request->file('despesas')->store('prestacoes_contas');
    
        // Armazenar fotos individualmente
        $fotosPaths = [];
        for ($i = 0; $i < 5; $i++) {
            if ($request->hasFile("fotos.$i")) {
                $fotosPaths[$i] = $request->file("fotos.$i")->store('prestacoes_contas/fotos');
            } else {
                $fotosPaths[$i] = null;
            }
        }
    
        // Salvar a prestação de contas no banco de dados
        PrestacaoConta::create([
            'idOng' => $idOng,
            'balanco' => $balancoPath,
            'demonstracao' => $demonstracaoPath,
            'receitas' => $receitasPath,
            'despesas' => $despesasPath,
            'foto1' => $fotosPaths[0],
            'foto2' => $fotosPaths[1],
            'foto3' => $fotosPaths[2],
            'foto4' => $fotosPaths[3],
            'foto5' => $fotosPaths[4],
        ]);
    
        return redirect()->back()->with('success', 'Prestação de contas enviada com sucesso!');
     }
    

public function index()
{
    $prestacoes = PrestacaoConta::with('ong')->get(); // Carrega as prestações de contas com as ONGs

    return view('prestacaoContaAdm', compact('prestacoes'));
}

}
