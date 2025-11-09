<?php

namespace App\Http\Controllers;

use App\Models\Legislacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegislacaoController extends Controller
{
    /**
     * Lista os documentos de legislação com paginação.
     * 
     * Quando acessado pelo prefixo 'admin', retorna a view
     * administrativa com opções de gerenciamento.
     */
    public function index(Request $request)
    {
        $legislacoes = Legislacao::latest()->paginate(10);

        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.legislacoes.index', compact('legislacoes'));
        }

        return view('legislacoes.index', compact('legislacoes'));
    }

    /**
     * Exibe os detalhes de um documento de legislação específico.
     */
    public function show(Legislacao $legislacao)
    {
        return view('legislacoes.show', compact('legislacao'));
    }

    /**
     * Exibe o formulário para criar um novo documento de legislação.
     */
    public function create()
    {
        return view('admin.legislacoes.create');
    }

    /**
     * Armazena um novo documento de legislação no banco de dados.
     * 
     * Valida os dados recebidos, faz upload do arquivo para o storage
     * e salva as informações incluindo estatuto social e certificado nacional.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'estatuto_social' => 'nullable|string|max:255',
            'certificado_nacional' => 'nullable|string|max:255',
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $path = $request->file('arquivo')->store('legislacoes', 'public');

        Legislacao::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'caminho_arquivo' => $path,
            'estatuto_social' => $request->estatuto_social,
            'certificado_nacional' => $request->certificado_nacional,
        ]);

        return redirect()->route('admin.legislacoes.index')->with('success', 'Legislação criada com sucesso.');
    }

    /**
     * Exibe o formulário para editar um documento de legislação existente.
     */
    public function edit(Legislacao $legislacao)
    {
        return view('admin.legislacoes.edit', compact('legislacao'));
    }

    /**
     * Atualiza as informações de um documento de legislação no banco.
     * 
     * Valida os novos dados e atualiza apenas os campos permitidos,
     * mantendo o arquivo original intacto.
     */
    public function update(Request $request, Legislacao $legislacao)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'estatuto_social' => 'nullable|string|max:255',
            'certificado_nacional' => 'nullable|string|max:255',
        ]);

        $legislacao->update($request->only(['titulo', 'descricao', 'estatuto_social', 'certificado_nacional']));

        return redirect()->route('admin.legislacoes.index')->with('success', 'Legislação atualizada com sucesso.');
    }

    /**
     * Remove um documento de legislação do banco e seu arquivo do storage.
     * 
     * Apaga primeiro o arquivo físico do disco público, depois
     * remove o registro do banco de dados.
     */
    public function destroy(Legislacao $legislacao)
    {
        Storage::disk('public')->delete($legislacao->caminho_arquivo);
        $legislacao->delete();

        return redirect()->route('admin.legislacoes.index')->with('success', 'Legislação excluída com sucesso.');
    }

    /**
     * Faz o download do arquivo associado ao documento de legislação.
     */
    public function download(Legislacao $legislacao)
    {
        return Storage::disk('public')->download($legislacao->caminho_arquivo);
    }

    /**
     * Exibe a pré-visualização do documento em uma nova aba.
     * 
     * Disponível apenas para arquivos PDF. Retorna uma view com
     * iframe apontando para o arquivo no storage público.
     */
    public function preview(Legislacao $legislacao)
    {
        if (!\Illuminate\Support\Str::endsWith($legislacao->caminho_arquivo, '.pdf')) {
            return back()->with('error', 'A pré-visualização está disponível apenas para arquivos PDF.');
        }

        $url = Storage::disk('public')->url($legislacao->caminho_arquivo);

        return view('legislacoes.preview', ['url' => $url, 'legislacao' => $legislacao]);
    }
}
