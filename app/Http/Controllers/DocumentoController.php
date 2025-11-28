<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $documentos = Documento::latest()->paginate(10);

        // Se a rota atual estiver no prefixo 'admin', retorna a view do admin
        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.documentos.index', compact('documentos'));
        }

        return view('documentos.index', compact('documentos'));
    }

    public function show(Documento $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    
    public function create()
    {
        return view('admin.documentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ata_diretoria' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
        ]);

        $path = $request->file('arquivo')->store('documentos', 'public');

        $documento = Documento::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'caminho_arquivo' => $path,
            'ata_diretoria' => $request->ata_diretoria,
            'cnpj' => $request->cnpj,
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento enviado com sucesso.');
    }

    
    public function edit(Documento $documento)
    {
        return view('admin.documentos.edit', compact('documento'));
    }

    
    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ata_diretoria' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:18',
        ]);

        $documento->update($request->only(['titulo', 'descricao', 'ata_diretoria', 'cnpj']));

        return redirect()->route('documentos.index')->with('success', 'Documento atualizado com sucesso.');
    }

    /**
     * Remove o arquivo associado do storage e deleta o registro.
     *
     * Apaga o arquivo no disco público e remove o registro do banco.
     */
    public function destroy(Documento $documento)
    {
    // Remove o arquivo do storage
        if ($documento->caminho_arquivo) {
            Storage::disk('public')->delete($documento->caminho_arquivo);
        }
        
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento excluído com sucesso.');
    }

    
    public function download(Documento $documento)
    {
        return Storage::disk('public')->download($documento->caminho_arquivo);
    }

    /**
     * Exibe pré-visualização do documento quando for PDF ou imagem.
     *
     * Valida a extensão e retorna a view com iframe/imagem apontando para a URL.
     */
    public function preview(Documento $documento)
    {
        $extensao = strtolower(pathinfo($documento->caminho_arquivo, PATHINFO_EXTENSION));
        $extensoesPermitidas = ['pdf', 'png', 'jpg', 'jpeg'];
        
        if (!in_array($extensao, $extensoesPermitidas)) {
            return back()->with('error', 'A pré-visualização está disponível apenas para arquivos PDF e imagens (PNG/JPG).');
        }

        $url = Storage::disk('public')->url($documento->caminho_arquivo);
        $ehImagem = in_array($extensao, ['png', 'jpg', 'jpeg']);

        return view('documentos.preview', ['url' => $url, 'documento' => $documento, 'ehImagem' => $ehImagem]);
    }

    /**
     * Lista os recursos para o admin.
     *
     * Ponto de entrada usado pela rota administrativa para exibir a
     * listagem de documentos.
     */

}