<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Doador;
use App\Models\Ong;
use App\Models\Campanha;
use App\Models\Postagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DoadorController extends Controller
{

    public function atualizarFoto(Request $request)
{
    $doador = Doador::find(auth()->id());

    $request->validate([
        'fotoDoador' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação da imagem
    ]);

    if ($request->hasFile('fotoDoador')) {
        // Armazena a nova imagem e atualiza o caminho no perfil do doador
        $path = $request->file('fotoDoador')->store('fotos_doador', 'public');
        $doador->fotoDoador = $path;
    }

    $doador->save();

    return response()->json([
        'newImageUrl' => asset('storage/' . $doador->fotoDoador),
    ]);
}


    public function atualizarPerfil(Request $request)
{
    $doador = Doador::find(auth()->id());

    $request->validate([
        'nomeDoador' => 'required|string|max:100',
        'nomeUsuarioDoador' => 'required|string|max:50',
        'emailDoador' => 'required|email',
        'biografiaDoador' => 'nullable|string|max:255',
    ]);

    $doador->nomeDoador = $request->input('nomeDoador');
    $doador->nomeUsuarioDoador = $request->input('nomeUsuarioDoador');
    $doador->emailDoador = $request->input('emailDoador');
    $doador->biografiaDoador = $request->input('biografiaDoador');
    $doador->save();

    return response()->json([
        'message' => 'Perfil atualizado com sucesso',
        'doador' => $doador // Retorne o doador atualizado
    ]);
}

    public function feed()
{
    $doador = Doador::find(auth()->id()); // Obtém o usuário logado

    if (!$doador) {
        return redirect()->route('login')->withErrors(['error' => 'Por favor, faça login para acessar o feed.']);
    }
    $doadorId = $doador->idDoador;
    $doador = Doador::find($doadorId);
    
    // Certifique-se de que o relacionamento entre Campanha e Ong esteja configurado corretamente
    $campanhas = Campanha::with('ong')->orderBy('created_at', 'desc')->get();
    $postagens = Postagem::with('ong')->orderBy('dataPostagem', 'desc')->get();

    return view('feedDoador', compact('doador', 'campanhas', 'postagens'));
}

   public function perfil()
{
    $doador = Doador::find(auth()->id());

    if (!$doador) {
        return redirect()->route('login')->withErrors(['error' => 'Por favor, faça login para acessar o perfil.']);
    }

    return view('perfilDoador', compact('doador'));
}


    public function adicionarComentario(Request $request)
    {
        $request->validate([
            'idPostagem' => 'required|exists:postagem,idPostagem',
            'conteudo' => 'required|string|max:255',
        ]);
    
        $comentario = new Comentario();
        $comentario->idPostagem = $request->idPostagem;
        $comentario->idDoador = auth()->id(); // Obtém o ID do doador logado
        $comentario->conteudo = $request->conteudo;
        $comentario->save();
    
        // Obtém informações do doador
        $doador = Doador::find(auth()->id());
        
        return response()->json([
            'success' => true,
            'comentario' => [
                'fotoDoador' => $doador->fotoDoador,
                'nomeDoador' => $doador->nomeDoador,
                'conteudo' => $comentario->conteudo,
            ]
        ]);
    }

    public function obterComentarios($idPostagem)
{
    $comentarios = Comentario::with('doador')->where('idPostagem', $idPostagem)->get();

    return response()->json([
        'comentarios' => $comentarios->map(function ($comentario) {
            return [
                'fotoDoador' => $comentario->doador->fotoDoador,
                'nomeDoador' => $comentario->doador->nomeDoador,
                'conteudo' => $comentario->conteudo,
            ];
        }),
    ]);
}


    public function index() {
        $search = request('search');
        $doadores = $search ? Doador::where('nomeDoador', 'like', '%'.$search.'%')->get() : Doador::all();
        return view('doadoresView', ['doadores' => $doadores, 'search' => $search]);
    }

    public function search(Request $request) {
        $search = $request->input('query');
        $doadores = Doador::where('nomeDoador', 'like', '%'.$search.'%')->get();
        return response()->json($doadores);
    }

    public function destroy($id){
        $doador = Doador::find($id);
        $doador->delete();
        return redirect()->route('admin.doadores');
    }

    public function create()
    {
        return view('cadastrodoador'); 
    }

    // Método para armazenar os dados do doador (formulário 1)
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'nomeDoador' => 'required|string|max:100',
            'emailDoador' => 'required|email|max:255|unique:doador,emailDoador',
            'senhaDoador' => 'required|string|min:8',
        ]);

        // Criação do doador
        $doador = Doador::create([
            'nomeDoador' => $request->nomeDoador,
            'emailDoador' => $request->emailDoador,
            'senhaDoador' => ($request->senhaDoador), // Senha criptografada
            'dataCadastroDoador' => now(), // Preencher a data de cadastro automaticamente
        ]);

        // Armazenar o ID do doador na sessão
        $request->session()->put('doador_id', $doador->idDoador);

        // Redirecionar para o próximo formulário
        return redirect()->route('doador.createProfile');
    }

    // Método para mostrar o formulário de criação do perfil do doador (formulário 2)
    public function showCreateProfile()
    {
        return view('criarperfildoador'); // Altere para o nome correto da view
    }

    // Método para concluir o cadastro do doador
    public function storeProfile(Request $request)
    {
        // Validação dos dados do perfil
        $request->validate([
            'fotoDoador' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nomeUsuarioDoador' => 'required|string|max:100',
            'biografiaDoador' => 'required|string|max:255',
            'causas' => 'nullable|array',
        ]);

        // Lógica para armazenar a foto do doador se houver
        $path = null;
        if ($request->hasFile('fotoDoador')) {
            $path = $request->file('fotoDoador')->store('fotos_doador', 'public');
        }

        // Recupera o ID do doador da sessão
        $doadorId = $request->session()->get('doador_id');
        $doador = Doador::find($doadorId);

        // Verifica se o doador foi encontrado
        if (!$doador) {
            return redirect()->route('doador.create')->withErrors(['error' => 'Doador não encontrado.']);
        }

        // Atualiza os dados do doador com o perfil
        $doador->update([
            'fotoDoador' => $path,
            'nomeUsuarioDoador' => $request->nomeUsuarioDoador,
            'biografiaDoador' => $request->biografiaDoador,
            // Adicione outros campos conforme necessário
        ]);

        // Redireciona para uma página de sucesso ou onde você quiser
        return view('/logindoador'); // Altere para a rota de sucesso ou onde quiser redirecionar
    }
}
