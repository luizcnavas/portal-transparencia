@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Registros Financeiros</h1>
        <a href="{{ route('admin.financeiros.create') }}" class="btn btn-primary">Adicionar Registro</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($financeiros as $financeiro)
                        <tr>
                            <td>{{ $financeiro->titulo }}</td>
                            <td>
                                @if($financeiro->tipo === 'receita')
                                    <span class="badge bg-success">Receita</span>
                                @else
                                    <span class="badge bg-danger">Despesa</span>
                                @endif
                            </td>
                            <td>R$ {{ number_format($financeiro->valor, 2, ',', '.') }}</td>
                            <td>{{ $financeiro->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.financeiros.edit', $financeiro) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.financeiros.destroy', $financeiro) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($financeiros->hasPages())
            <div class="card-footer">
                {{ $financeiros->links() }}
            </div>
        @endif
    </div>
@endsection
