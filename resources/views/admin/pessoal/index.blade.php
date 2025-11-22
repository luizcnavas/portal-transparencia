@extends('layouts.app')

@section('content')
<h1 class="tituloP">Associação das Entidades Assistenciais e de Promoção Social de Bauru e Região</h1>
<h3 class="subtituloP">Diretoria da Associação das Entidades Assistenciais e de Promoção Social de Bauru e Região - 2023 a 2025</h3>
    <div class="d-flex align-items-center mb-4 caixaAdd">
        @auth
            <a href="{{ route('admin.pessoal.create') }}" class="btn add">Adicionar Pessoa</a>
        @endauth
    </div>

    <div class="pessoal">
        @forelse($pessoal as $pessoa)
            <div class="sect">
                <div class="fotoP">
                    @if (! $pessoa->foto || str_contains($pessoa->foto, 'FotoVazia'))
                        <img class="imgFotoP" src="{{ asset('assets/img/FotoVazia.jpg') }}" alt="{{ $pessoa->nome }}">
                    @else
                        <img class="imgFotoP" src="{{ asset('storage/' . $pessoa->foto) }}" alt="{{ $pessoa->nome }}">
                    @endif
                </div>
                <div class="infoP">
                    <p class="NomeP">{{ $pessoa->nome }}</p>
                    <span class="cargoP">{{ $pessoa->cargo }}</span>
                </div>

                @auth
                    <div class="mt-2">
                        <a href="{{ route('admin.pessoal.edit', $pessoa) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('admin.pessoal.destroy', $pessoa) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Tem certeza que deseja excluir?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </div>
                @endauth
            </div>
        @empty
            <p class="text-center mt-4">Nenhum membro cadastrado.</p>
        @endforelse
    </div>

    @if($pessoal->hasPages())
        <div class="card-footer mt-3">
            {{ $pessoal->links() }}
        </div>
    @endif

@endsection
