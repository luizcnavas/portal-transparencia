<?php

namespace App\Http\Controllers;

use App\Models\Financeiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinanceiroController extends Controller
{
    /**
     * Lista os registros financeiros com filtros disponíveis.
     * 
     * Permite filtrar por tipo (receita ou despesa) e realizar buscas
     * em múltiplos campos. Retorna a view administrativa quando acessado
     * pelo prefixo 'admin'.
     */
    public function index(Request $request)
    {
        $request->validate([
            'tipo' => 'nullable|in:receita,despesa',
            'search' => 'nullable|string|max:255',
        ]);

        $tipo = $request->query('tipo');
        $search = $request->query('search');

        $query = Financeiro::query();
        
        if ($tipo) {
            $query->where('tipo', $tipo);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('planejamento_estrategico', 'like', "%{$search}%");
            });
        }

        $financeiros = $query->latest()->paginate(10);

        // Se a rota atual estiver no prefixo 'admin', retorna a view do admin
        $route = request()->route();
        $prefix = $route ? $route->getPrefix() : null;
        if ($prefix && str_starts_with(trim($prefix, '/'), 'admin')) {
            return view('admin.financeiros.index', compact('financeiros', 'tipo'));
        }

        return view('financeiros.index', compact('financeiros', 'tipo', 'search'));
    }

    
    public function show(Financeiro $financeiro)
    {
        return view('financeiros.show', compact('financeiro'));
    }

    
    public function create()
    {
        return view('admin.financeiros.create');
    }

    /**
     * Armazena um novo registro financeiro no banco de dados.
     * 
     * Valida os dados recebidos, faz upload do arquivo para o storage
     * público e salva as informações no banco.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'tipo' => 'required|in:receita,despesa',
            'valor' => 'required|numeric|min:0',
            'planejamento_estrategico' => 'nullable|string',
            'arquivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
        ]);

        $path = $request->file('arquivo')->store('financeiros', 'public');

        $financeiro = Financeiro::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'caminho_arquivo' => $path,
            'tipo' => $request->tipo,
            'valor' => $request->valor,
            'planejamento_estrategico' => $request->planejamento_estrategico,
        ]);

        return redirect()->route('financeiros.index')->with('success', 'Registro financeiro criado com sucesso.');
    }

    
    public function edit(Financeiro $financeiro)
    {
        return view('admin.financeiros.edit', compact('financeiro'));
    }

    /**
     * Atualiza as informações de um registro financeiro no banco.
     * 
     * Valida os novos dados e atualiza apenas os campos permitidos,
     * mantendo o arquivo original intacto.
     */
    public function update(Request $request, Financeiro $financeiro)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'tipo' => 'required|in:receita,despesa',
            'valor' => 'required|numeric|min:0',
            'planejamento_estrategico' => 'nullable|string',
        ]);

        $financeiro->update($request->only(['titulo', 'descricao', 'tipo', 'valor', 'planejamento_estrategico']));

        return redirect()->route('financeiros.index')->with('success', 'Registro financeiro atualizado com sucesso.');
    }

    /**
     * Remove um registro financeiro do banco e seu arquivo do storage.
     * 
     * Apaga primeiro o arquivo físico do disco público, depois
     * remove o registro do banco de dados.
     */
    public function destroy(Financeiro $financeiro)
    {
        // Verifica se há um arquivo antes de tentar deletar
        if ($financeiro->caminho_arquivo) {
            Storage::disk('public')->delete($financeiro->caminho_arquivo);
        }
        $financeiro->delete();

        return redirect()->route('financeiros.index')->with('success', 'Registro financeiro excluído com sucesso.');
    }

    
    public function download(Financeiro $financeiro)
    {
        return Storage::disk('public')->download($financeiro->caminho_arquivo);
    }

    /**
     * Exibe a pré-visualização do documento em uma nova aba.
     * 
     * Disponível para arquivos PDF e imagens. Retorna uma view com
     * iframe ou imagem apontando para o arquivo no storage público.
     */
    public function preview(Financeiro $financeiro)
    {
        $extensao = strtolower(pathinfo($financeiro->caminho_arquivo, PATHINFO_EXTENSION));
        $extensoesPermitidas = ['pdf', 'png', 'jpg', 'jpeg'];
        
        if (!in_array($extensao, $extensoesPermitidas)) {
            return back()->with('error', 'A pré-visualização está disponível apenas para arquivos PDF e imagens (PNG/JPG).');
        }

        $url = Storage::disk('public')->url($financeiro->caminho_arquivo);
        $ehImagem = in_array($extensao, ['png', 'jpg', 'jpeg']);

        return view('financeiros.preview', ['url' => $url, 'financeiro' => $financeiro, 'ehImagem' => $ehImagem]);
    }
}
