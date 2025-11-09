<?php

namespace App\Http\Controllers;

use App\Models\Informacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformacaoController extends Controller
{
    /**
     * Lista as informações institucionais com paginação.
     * 
     * Quando acessado pelo prefixo 'admin', retorna a view
     * administrativa com opções de gerenciamento.
     */
    public function index()
    {
        $informacoes = Informacao::latest()->paginate(10);

        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.informacoes.index', compact('informacoes'));
        }

        return view('informacoes.index', compact('informacoes'));
    }

    /**
     * Exibe os detalhes de uma informação institucional específica.
     */
    public function show(Informacao $informacao)
    {
        return view('informacoes.show', compact('informacao'));
    }

    /**
     * Exibe o formulário para criar uma nova informação institucional.
     */
    public function create()
    {
        return view('admin.informacoes.create');
    }

    /**
     * Armazena uma nova informação institucional no banco de dados.
     * 
     * Valida os dados recebidos e faz upload opcional do documento.
     * Salva múltiplos campos institucionais incluindo impacto social,
     * estrutura administrativa e contatos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'informacoes_institucionais' => 'nullable|string',
            'impacto_social' => 'nullable|string',
            'estrutura_administrativa' => 'nullable|string',
            'contatos' => 'nullable|string',
            'documento' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('documento')) {
            $path = $request->file('documento')->store('informacoes', 'public');
        }

        Informacao::create([
            'titulo' => $request->titulo,
            'conteudo' => $request->conteudo,
            'informacoes_institucionais' => $request->informacoes_institucionais,
            'impacto_social' => $request->impacto_social,
            'estrutura_administrativa' => $request->estrutura_administrativa,
            'contatos' => $request->contatos,
            'caminho_documento' => $path,
        ]);

        return redirect()->route('admin.informacoes.index')->with('success', 'Informação criada com sucesso.');
    }

    /**
     * Exibe o formulário para editar uma informação institucional existente.
     */
    public function edit(Informacao $informacao)
    {
        return view('admin.informacoes.edit', compact('informacao'));
    }

    /**
     * Atualiza as informações de uma informação institucional no banco.
     * 
     * Valida os novos dados e atualiza apenas os campos de texto,
     * mantendo o documento original intacto.
     */
    public function update(Request $request, Informacao $informacao)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'informacoes_institucionais' => 'nullable|string',
            'impacto_social' => 'nullable|string',
            'estrutura_administrativa' => 'nullable|string',
            'contatos' => 'nullable|string',
        ]);

        $informacao->update($request->only(['titulo', 'conteudo', 'informacoes_institucionais', 'impacto_social', 'estrutura_administrativa', 'contatos']));

        return redirect()->route('admin.informacoes.index')->with('success', 'Informação atualizada com sucesso.');
    }

    /**
     * Remove uma informação institucional do banco e seu documento do storage.
     * 
     * Verifica se há documento anexo e o remove antes de deletar
     * o registro do banco de dados.
     */
    public function destroy(Informacao $informacao)
    {
        if ($informacao->caminho_documento) {
            Storage::disk('public')->delete($informacao->caminho_documento);
        }
        $informacao->delete();

        return redirect()->route('admin.informacoes.index')->with('success', 'Informação excluída com sucesso.');
    }

    /**
     * Faz o download do documento anexo à informação institucional.
     * 
     * Retorna erro caso não haja documento disponível.
     */
    public function download(Informacao $informacao)
    {
        if ($informacao->caminho_documento) {
            return Storage::disk('public')->download($informacao->caminho_documento);
        }
        return back()->with('error', 'Nenhum documento disponível.');
    }
}
