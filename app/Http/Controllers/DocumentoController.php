<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Lista documentos públicos com filtros disponíveis.
     *
     * Aplica filtros por categoria/tipo e usa paginação. Quando a rota
     * pertence ao prefixo 'admin', retorna a view administrativa com
     * opções de CRUD.
     */
    public function index(Request $request)
    {
        $request->validate([
            'tipo' => 'nullable|in:receita,despesa',
        ]);

        $tipo = $request->query('tipo');

        $query = Documento::query();
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        $documentos = $query->latest()->paginate(10);
        $categorias = Documento::select('categoria')->distinct()->pluck('categoria');

    // Se a rota atual estiver no prefixo 'admin', retorna a view do admin
        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.documentos.index', compact('documentos', 'tipo'));
        }

        return view('documentos.index', compact('documentos', 'categorias', 'tipo'));
    }

    /**
     * Mostra a página de detalhes de um documento.
     *
     * Recebe o documento via route-model binding e retorna a view.
     */
    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    /**
     * Formulário de criação de documento (admin).
     */
    public function create()
    {
        return view('admin.documentos.create');
    }

    /**
     * Valida os dados e armazena um novo documento (faz upload do arquivo).
     *
     * Verifica tipos e tamanho do arquivo, depois salva o caminho no storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string|max:100',
            'tipo' => 'required|in:receita,despesa',
            'valor' => 'required|numeric|min:0',
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // Máx 10MB
        ]);

        $path = $request->file('arquivo')->store('documentos', 'public');

        Documento::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'categoria' => $request->categoria,
            'caminho_arquivo' => $path,
            'tipo' => $request->tipo,
            'valor' => $request->valor,
        ]);

        return redirect()->route('admin.documentos.index')->with('success', 'Documento enviado com sucesso.');
    }

    /**
     * Formulário de edição de metadados do documento (admin).
     */
    public function edit(Documento $documento)
    {
        return view('admin.documentos.edit', compact('documento'));
    }

    /**
     * Atualiza os metadados do documento.
     */
    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string|max:100',
            'tipo' => 'required|in:receita,despesa',
            'valor' => 'required|numeric|min:0',
        ]);

        $documento->update($request->only(['titulo', 'descricao', 'categoria', 'tipo', 'valor']));

        return redirect()->route('admin.documentos.index')->with('success', 'Documento atualizado com sucesso.');
    }

    /**
     * Remove o arquivo associado do storage e deleta o registro.
     *
     * Apaga o arquivo no disco público e remove o registro do banco.
     */
    public function destroy(Documento $documento)
    {
    // Remove o arquivo do storage
        Storage::disk('public')->delete($documento->caminho_arquivo);
        
        $documento->delete();

        return redirect()->route('admin.documentos.index')->with('success', 'Documento excluído com sucesso.');
    }

    /**
     * Fornece o download do arquivo armazenado do documento.
     */
    public function download(Documento $documento)
    {
        return Storage::disk('public')->download($documento->caminho_arquivo);
    }

    /**
     * Exibe pré-visualização do documento quando for PDF.
     *
     * Valida a extensão e retorna a view com iframe apontando para a URL.
     */
    public function preview(Documento $documento)
    {
        if (!\Illuminate\Support\Str::endsWith($documento->caminho_arquivo, '.pdf')) {
            return back()->with('error', 'A pré-visualização está disponível apenas para arquivos PDF.');
        }

        $url = \Illuminate\Support\Facades\Storage::disk('public')->url($documento->caminho_arquivo);

        return view('documentos.preview', ['url' => $url, 'documento' => $documento]);
    }

    /**
     * Lista os recursos para o admin.
     *
     * Ponto de entrada usado pela rota administrativa para exibir a
     * listagem de documentos.
     */

}