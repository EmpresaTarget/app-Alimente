<?php

namespace App\Http\Controllers;

use App\Models\Curtida;
use App\Models\Postagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostagemController extends Controller
{

    public function verificarCurtida($postId)
{
    $userId = auth()->id();
    $jaCurtiu = Curtida::where('doador_id', $userId)
                        ->where('postagem_id', $postId)
                        ->exists();
    return response()->json(['jaCurtiu' => $jaCurtiu]);
}

public function curtirPostagem(Request $request, $postId)
{
    $userId = auth()->id();
    
    // Verifica se o usuário já curtiu a postagem
    $curtidaExistente = Curtida::where('doador_id', $userId)
                               ->where('postagem_id', $postId)
                               ->first();

    if ($curtidaExistente) {
        // Se já curtiu, apenas retorna a contagem atual de curtidas
        return response()->json([
            'message' => 'Já curtiu', 
            'curtidas' => Postagem::find($postId)->curtidas->count()
        ]);
    }

    // Registra a curtida
    Curtida::create([
        'doador_id' => $userId,
        'postagem_id' => $postId,
    ]);

    // Atualiza o campo 'numeroCurtidas' na tabela 'postagem'
    $postagem = Postagem::find($postId);
    $postagem->numeroCurtidas += 1;  // Incrementa em 1
    $postagem->save();

    // Retorna a nova contagem de curtidas
    $numeroCurtidas = $postagem->numeroCurtidas;

    return response()->json([
        'message' => 'Curtiu com sucesso', 
        'curtidas' => $numeroCurtidas
    ]);
}

public function destroy($id)
{
    // Buscar a postagem pelo ID ou retornar erro se não encontrada
    $postagem = Postagem::findOrFail($id);

    // Excluir a postagem
    $postagem->delete();

    // Retornar uma resposta de sucesso
    return response()->json([
        'success' => true,
        'message' => 'Postagem excluída com sucesso!'
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'conteudo' => 'required|string|max:255',
        'chavePix' => 'nullable|string|max:255',
        'hashtags' => 'nullable|string',
        'imagem' => 'nullable|image|max:2048',
    ]);

    $postagem = Postagem::findOrFail($id);

    $postagem->conteudo = $request->conteudo;
    $postagem->hashtags = $request->hashtags;
    $postagem->chavePix = $request->input('chavePix');

    if ($request->hasFile('imagem')) {
        // Armazenar a imagem e guardar o caminho
        $path = $request->file('imagem')->store('uploads', 'public');
        $postagem->imagem = $path;
    }

    $postagem->save();

    return response()->json([
        'success' => true,
        'message' => 'Postagem atualizada com sucesso!'
    ]);
}

    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'conteudo' => 'required|string|max:255',
            'idOng' => 'required|exists:ong,idOng',
            'hashtags' => 'nullable|string',
            'imagem' => 'nullable|image|max:2048',
            'chavePix' => 'nullable|string|max:255', 
        ]);

        try {
            // Criação de uma nova postagem
            $postagem = new Postagem();
            $postagem->idOng = $request->input('idOng');
            $postagem->conteudo = $request->input('conteudo');
            $postagem->hashtags = $request->input('hashtags');
            $postagem->chavePix = $request->input('chavePix');

            // Tratamento da imagem
            if ($request->hasFile('imagem')) {
                // Armazenar a imagem e guardar o caminho
                $path = $request->file('imagem')->store('uploads', 'public');
                $postagem->imagem = $path;
            }

            // Salvar a postagem no banco de dados
            $postagem->save();

            // Retornar uma resposta JSON de sucesso
            return response()->json(['message' => 'Postagem criada com sucesso!', 'postagem' => $postagem], 201);
        } catch (\Exception $e) {
            // Log do erro para diagnóstico
            Log::error('Erro ao criar postagem: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao criar a postagem.'], 500);
        }
    }
}
