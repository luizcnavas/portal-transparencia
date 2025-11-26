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
        <h1 class="titulo">Gerenciar Notícias</h1>
        <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary add">Adicionar Nova</a>
    </div>
    {{-- Anotação: lista de notícias para administração; ações de CRUD disponíveis. --}}

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
                        <th class="TituloTabela">Data de Criação</th>
                        <th class="TituloTabelaAcao acaoNoticia">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($noticias as $noticia)
                        <tr>
                            <td>{{ $noticia->titulo }}</td>
                            <td>{{ $noticia->created_at->format('d/m/Y') }}</td>
                            <td class="text-end btnsTab">
                                <a href="{{ route('admin.noticias.edit', $noticia) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/botao-editar.png') }}" alt="Editar"/></a>
                                <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/excluir.png') }}" alt="Excluir"/></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Nenhuma notícia encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($noticias->hasPages())
            <div class="card-footer">
                {{ $noticias->links() }}
            </div>
        @endif
    </div>
@endsection