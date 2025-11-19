<?php

namespace App\Http\Controllers;

use App\Models\Pessoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PessoalController extends Controller
{
    /**
     * Lista documentos públicos com paginação.
     *
     * Quando a rota pertence ao prefixo 'admin', retorna a view
     * administrativa com opções de CRUD.
     */
    public function index(Request $request)
    {
        $pessoal = Pessoal::latest()->paginate(10);

        // Se a rota atual estiver no prefixo 'admin', retorna a view do admin
        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.pessoal.index', compact('pessoal'));
        }

        return view('pessoal.index', compact('pessoal'));
    }

    /**
     * Mostra a página de detalhes de um documento.
     *
     * Recebe o documento via route-model binding e retorna a view.
     */
    public function show(Pessoa $pessoa)
    {
        return view('pessoal.show', compact('pessoal'));
    }

    /**
     * Formulário de criação de documento (admin).
     */
    public function create()
    {
        return view('admin.pessoal.create');
    }

    /**
     * Valida os dados e armazena um novo documento (faz upload do arquivo).
     *
     * Verifica tipos e tamanho do arquivo, depois salva o caminho no storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=> 'required|string|max:255',
            'cargo'=> 'required|string|max:255',
            'foto' => 'nullable|file|mimes:png,jpg,jpeg|max:10240',
        ]);

        $path = $request->file('foto')->store('pessoal', 'public');

        Pessoal::create([
            'nome' => $request->nome,
            'cargo' => $request->cargo,
            'foto' => $path,
        ]);

        return redirect()->route('admin.pessoal.index')->with('success', 'Pessoa adicionada com sucesso.');
    }

    /**
     * Formulário de edição de metadados do documento (admin).
     */
    public function edit(Pessoal $pessoal)
    {
        return view('admin.pessoal.edit', compact('pessoal'));
    }

    /**
     * Atualiza os metadados do documento.
     */
    public function update(Request $request, Pessoal $pessoal)
    {
        $request->validate([
            'nome'=> 'required|string|max:255',
            'cargo'=> 'required|string|max:255',
            'foto' => 'nullable|file|mimes:png,jpg,jpeg|max:10240',
        ]);

        $pessoal->update($request->only(['nome','cargo','foto']));

        return redirect()->route('admin.pessoal.index')->with('success', 'Pessoa atualizada com sucesso.');
    }

    /**
     * Remove o arquivo associado do storage e deleta o registro.
     *
     * Apaga o arquivo no disco público e remove o registro do banco.
     */
    public function destroy(Pessoal $pessoal)
    {
    // Remove o arquivo do storage
        Storage::disk('public')->delete($pessoal->foto);
        
        $pessoal->delete();

        return redirect()->route('admin.pessoal.index')->with('success', 'Pessoa excluída com sucesso.');
    }


    /**
     * Lista os recursos para o admin.
     *
     * Ponto de entrada usado pela rota administrativa para exibir a
     * listagem de documentos.
     */

}