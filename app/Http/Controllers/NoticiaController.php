<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
    * Lista de notícias.
    *
    * Anotação: filtra e pagina notícias. Quando a requisição for feita a partir
    * do prefixo 'admin' retornamos a view de administração (combotões de CRUD).
    * Comentário alterado apenas para claridade; lógica preservada.
    */
    public function index()
    {
        $noticias = Noticia::latest()->paginate(10);

    // Verifica se a rota atual é do admin e retorna a view correspondente
        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.noticias.index', compact('noticias'));
        }

        return view('noticias.index', compact('noticias'));
    }

    /**
     * Mostra a notícia especificada.
     *
     * Anotação: recebe o model `Noticia` por route-model binding e retorna a view.
     */
    public function show(Noticia $noticia)
    {
        return view('noticias.show', compact('noticia'));
    }

    /**
     * Formulário de criação de notícia (admin).
     */
    public function create()
    {
        return view('admin.noticias.create');
    }

    /**
     * Valida e armazena uma nova notícia.
     *
     * Anotação: validação simples de título e conteúdo; redireciona com mensagem.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
        ]);

        Noticia::create($request->all());

        return redirect()->route('admin.noticias.index')->with('success', 'Notícia criada com sucesso.');
    }

    /**
     * Formulário de edição de notícia (admin).
     */
    public function edit(Noticia $noticia)
    {
        return view('admin.noticias.edit', compact('noticia'));
    }

    /**
     * Atualiza metadados da notícia.
     */
    public function update(Request $request, Noticia $noticia)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
        ]);

        $noticia->update($request->all());

        return redirect()->route('admin.noticias.index')->with('success', 'Notícia atualizada com sucesso.');
    }

    /**
     * Remove a notícia.
     */
    public function destroy(Noticia $noticia)
    {
        $noticia->delete();
        return redirect()->route('admin.noticias.index')->with('success', 'Notícia excluída com sucesso.');
    }
    
    /**
     * Display a listing of the resource for admin.
     */

}