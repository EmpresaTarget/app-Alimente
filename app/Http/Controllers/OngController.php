<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ong; 
use App\Models\Postagem;
use App\Models\Doacao;
use App\Models\PrestacaoConta;
use Illuminate\Http\Request;

class OngController extends Controller
{

    public function registrarDoacao(Request $request)
    {
        $ongId = $request->input('ongId');
        $valor = $request->input('valor');
        $mes = $request->input('mes');
        $ano = $request->input('ano');

        try {
            // Salvar doação no banco de dados
            $doacao = new Doacao();
            $doacao->ongId = $ongId;
            $doacao->valor = $valor;
            $doacao->mes = $mes;
            $doacao->ano = $ano;
            $doacao->save();

            return response()->json(['success' => true, 'message' => 'Doação registrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function atualizarArrecadacao(Request $request)
    {
        // Encontrar a ONG pela ID
        $ongId = $request->input('ongId'); // ID da ONG
        $valor = $request->input('valor'); // Valor a ser somado ao total arrecadado
    
        // Verifique se a ONG existe
        $ong = Ong::where('idOng', $ongId)->first();
    
        if ($ong) {
            // Atualiza o total arrecadado somando o valor novo
            $ong->totalArrecadado += $valor;
            $ong->save(); // Salva a mudança no banco de dados
    
            return response()->json(['success' => true, 'message' => 'Arrecadação atualizada com sucesso!']);
        } else {
            return response()->json(['success' => false, 'message' => 'ONG não encontrada.']);
        }
    }
    

    public function searchDoador(Request $request)
    {
        $search = $request->input('search');
        $ongs = Ong::where('nomeUsuarioOng', 'like', '%'.$search.'%')->get();

        return response()->json($ongs);
    }

    public function perfil()
    {
        $ong = auth()->user(); // ou o método que você está utilizando para obter a ONG logada
        $numeroPostagens = $ong->postagens()->count(); // Contagem de postagens
        $numeroCampanhas = $ong->campanhas()->count(); // Contagem de campanhas
        $postagens = $ong->postagens; // Certifique-se de que você tem o relacionamento definido
        $campanhas = $ong->campanhas;
    
        return view('perfilOng', compact('ong', 'numeroPostagens', 'numeroCampanhas', 'postagens', 'campanhas'));
    
    }

    public function prestarConta()
{
    $ong = auth()->user(); // or however you retrieve the ONG
    return view('prestarContaOng', compact('ong'));
}

    public function index() {
        $search = request('search');
        $ongs = $search ? Ong::where('nomeOng', 'like', '%'.$search.'%')->get() : Ong::all();
        return view('ongsView', ['ongs' => $ongs, 'search' => $search]);
    }

    public function search(Request $request) {
        $search = $request->input('query');
        $ongs = Ong::where('nomeOng', 'like', '%'.$search.'%')->get();
        return response()->json($ongs);
    }
    public function destroy($id){
        $ong = Ong::find($id);
        $ong->delete();
        return redirect()->route('admin.ongs');
    }

    // Método para exibir o primeiro passo do cadastro da ONG
    public function showFirstStep()
    {
        return view('cadastroOng'); // Certifique-se de que a view existe
    }

    // Método para armazenar os dados do primeiro formulário
    public function storeFirstStep(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nomeOng' => 'required|string|max:255',
            'emailOng' => 'required|email|max:255|unique:ong,emailOng',
            'senhaOng' => 'required|string|min:8',
            'cnpjOng' => 'required|string|max:14', // Ajuste conforme necessário
            'cepOng' => 'nullable|string|max:10',
            'enderecoOng' => 'nullable|string|max:255',
            'numeroOng' => 'nullable|string|max:50',
            'complementoOng' => 'nullable|string|max:255',
            'bairroOng' => 'nullable|string|max:100',
            'cidadeOng' => 'nullable|string|max:100',
            'estadoOng' => 'nullable|string|max:50',
        ]);

        // Criação da nova ONG
        $ong = Ong::create([
            'nomeOng' => $validatedData['nomeOng'],
            'emailOng' => $validatedData['emailOng'],
            'senhaOng' => ($validatedData['senhaOng']), // Criptografando a senha
            'cnpjOng' => $validatedData['cnpjOng'],
            'cepOng' => $validatedData['cepOng'], // Corrigido para usar a validação
            'enderecoOng' => $validatedData['enderecoOng'], // Corrigido para usar a validação
            'numeroOng' => $validatedData['numeroOng'], // Corrigido para usar a validação
            'complementoOng' => $validatedData['complementoOng'], // Corrigido para usar a validação
            'bairroOng' => $validatedData['bairroOng'], // Corrigido para usar a validação
            'cidadeOng' => $validatedData['cidadeOng'], // Corrigido para usar a validação
            'estadoOng' => $validatedData['estadoOng'], // Corrigido para usar a validação
            'dataCadastroOng' => now(), // Preencher a data de cadastro automaticamente
            
        ]);

        $request->session()->put('ong_id', $ong->idOng);

        // Redirecionar para a configuração do perfil da ONG
        return view('configPerfilOng');
    }

    // Método para exibir a configuração do perfil da ONG
    public function showProfileConfig()
    {
        return view('configPerfilOng'); // Certifique-se de que a view existe
    }

    // Método para armazenar os dados do perfil da ONG
    public function storeProfileConfig(Request $request)
    {
        // Validação dos dados do perfil
        $validatedData = $request->validate([
            'fotoOng' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nomeUsuarioOng' => 'required|string|max:255',
            'biografiaOng' => 'required|string|max:1000',
        ]);
    
        // Inicializa a variável de caminho da foto
        $path = null;
    
        // Verifica se existe um arquivo de foto
        if ($request->hasFile('fotoOng')) {
            $filename = time() . '.' . $request->fotoOng->extension(); // Cria um nome único para o arquivo
            $request->fotoOng->storeAs('uploads', $filename, 'public'); // Salva no diretório 'public/uploads'
            $path = $filename; // Atribui o nome do arquivo à variável path
        }
    
        // Recupera o ID do doador da sessão
        $ongId = $request->session()->get('ong_id');
        $ong = Ong::find($ongId);
    
        // Verifica se a ONG existe
        if (!$ong) {
            return redirect()->back()->with('error', 'ONG não encontrada.'); // Retorna um erro se a ONG não for encontrada
        }
    
        // Atualiza os dados da ONG
        $ong->update([
            'fotoOng' => $path, // Usa a variável path
            'nomeUsuarioOng' => $validatedData['nomeUsuarioOng'], // Corrigido para usar o nome correto
            'biografiaOng' => $validatedData['biografiaOng'], // Corrigido para usar o nome correto
            // Adicione outros campos conforme necessário
        ]);

        // Redirecionar ou retornar uma resposta após a atualização
        return view('logindoador');
    }


      /**
 * Autorização de login
 */
public function login(Request $request)
{ 
    //verificar se o usualio e uma ong
    $ong = Ong::where('emailOng',$request->email)->first();

    if ($ong){
        $isPasswordValid = Hash::check($request->senha,$ong->senhaOng);

        if ($isPasswordValid && $ong-->statusPrestacaoContas ==='ativo'){
            $token = $ong->createToken('Ong') ->plainTextToken;
            return response()->json([
                'message' => 'Autentificado como Ong com sucesso!',
                'token' => $token,
                'tipoUsuario' => 'ong'
            
            ], 200 );
        }else if ($ong->statusPrestacaoContas ==='pendente'){
            return response()->json(['message'=> 'Ong pendente!'], 401);
        }else if ($ong->statusPrestacaoContas === 'arquivado'){
            return response ()->json(['message' =>'Ong arquivada!'], 401);
        }else {
            return response ()->json(['mensagem'=>'Credencías inválidas!'], 401);
        }
    }
}

}
    