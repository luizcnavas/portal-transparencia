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
        <h1 class="titulo">Gerenciar Legislações</h1>
        <a href="{{ route('admin.legislacoes.create') }}" class="btn btn-primary add">Adicionar Legislação</a>
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
                        <th class="TituloTabela">Estatuto Social</th>
                        <th class="TituloTabela">Certificado Nacional</th>
                        <th class="TituloTabela">Data</th>
                        <th class="TituloTabelaAcao acaoLeg">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($legislacoes as $legislacao)
                        <tr>
                            <td>{{ $legislacao->titulo }}</td>
                            <td>{{ $legislacao->estatuto_social ?? '—' }}</td>
                            <td>{{ $legislacao->certificado_nacional ?? '—' }}</td>
                            <td>{{ $legislacao->created_at->format('d/m/Y') }}</td>
                            <td class="text-end btnsTab">
                                <a href="{{ route('admin.legislacoes.edit', $legislacao) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/botao-editar.png') }}" alt="Editar"/></a>
                                <form action="{{ route('admin.legislacoes.destroy', $legislacao) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/excluir.png') }}" alt="Excluir"/></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma legislação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($legislacoes->hasPages())
            <div class="card-footer">
                {{ $legislacoes->links() }}
            </div>
        @endif
    </div>
@endsection
