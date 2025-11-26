@extends('layouts.app')
@push('styles')
<style>
    table.table thead.cabecalho th {
        background-color: #20752b !important;
        color: #fff !important;
    }
    table.table thead.cabecalho th:first-child {
        border-top-left-radius: 8px;
    }

    table.table thead.cabecalho th:last-child {
        border-top-right-radius: 8px;
    }

</style>
@endpush
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="titulo">Gerenciar Informações</h1>
        <a href="{{ route('admin.informacoes.create') }}" class="btn btn-primary add">Adicionar Informação</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="table-responsive voltaTab">
            <table class="table table-hover tabela">
                <thead class="cabecalho">
                    <tr>
                        <th class="TituloTabela">Título</th>
                        <th class="TituloTabela">Conteúdo</th>
                        <th class="TituloTabela">Documento</th>
                        <th class="TituloTabela">Data</th>
                        <th class="TituloTabelaAcao acaoInfo">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($informacoes as $informacao)
                        <tr>
                            <td>{{ $informacao->titulo }}</td>
                            <td>{{ Str::limit($informacao->conteudo, 50) }}</td>
                            <td>
                                @if($informacao->caminho_documento)
                                    <span class="badge bg-success">Sim</span>
                                @else
                                    <span class="badge bg-secondary">Não</span>
                                @endif
                            </td>
                            <td>{{ $informacao->created_at->format('d/m/Y') }}</td>
                            <td class="text-end btnsTab">
                                <a href="{{ route('admin.informacoes.edit', $informacao) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/botao-editar.png') }}" alt="Editar"/></a>
                                <form action="{{ route('admin.informacoes.destroy', $informacao) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/excluir.png') }}" alt="Excluir"/></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma informação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($informacoes->hasPages())
            <div class="card-footer">
                {{ $informacoes->links() }}
            </div>
        @endif
    </div>
@endsection
