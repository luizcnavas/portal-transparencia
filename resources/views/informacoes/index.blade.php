@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="titulo">Informações</h1>
        @auth
            <a href="{{ route('admin.informacoes.create') }}" class="btn btn-primary add">Adicionar Informação</a>
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="masonry">
        @forelse($informacoes as $informacao)
            <div class="masonry-item">
                <div class="card cardInfo">
                    <div class="card-body">
                        <h2 class="card-title tituloNoticia">{{ $informacao->titulo }}</h2>
                        <p class="card-text"><small class="text-muted dataNoticia">Publicado em {{ $informacao->created_at->format('d/m/Y') }}</small></p>
                        <p class="card-text txtNoticia">{{ Str::limit($informacao->conteudo, 200) }}</p>
                        @if($informacao->informacoes_institucionais)
                            <div class="mb-3">
                                <h5 class="text-success subtitulo1">Informações Institucionais</h5>
                                <p class="card-text txtNoticia">{{ Str::limit($informacao->informacoes_institucionais, 150) }}</p>
                            </div>
                        @endif
                        
                        @if($informacao->impacto_social)
                            <div class="mb-3">
                                <h5 class="text-primary subtitulo2">Impacto Social</h5>
                                <p class="card-text txtNoticia">{{ Str::limit($informacao->impacto_social, 150) }}</p>
                            </div>
                        @endif
                        
                        @if($informacao->estrutura_administrativa)
                            <div class="mb-3">
                                <h5 class="text-info subtitulo3">Estrutura Administrativa</h5>
                                <p class="card-text txtNoticia">{{ Str::limit($informacao->estrutura_administrativa, 150) }}</p>
                            </div>
                        @endif
                        
                        @if($informacao->contatos)
                            <div class="mb-3">
                                <h5 class="text-warning subtitulo4">Contatos</h5>
                                <p class="card-text txtNoticia">{{ Str::limit($informacao->contatos, 150) }}</p>
                            </div>
                        @endif
                        
                        <div class="btnNoticia">
                            <a href="{{ route('informacoes.show', $informacao) }}" class="btn lerMais">Leia mais</a>
                            
                            @if($informacao->caminho_documento)
                                <a href="{{ route('informacoes.download', $informacao) }}" class="btn botaoTab"><img class="imgBtn imgBtnDoc" src="{{ asset('assets/img/botoes/paraTabelas/file.png') }}" alt="Baixar Documento"/></a>
                            @endif
                            
                            @auth
                                <a href="{{ route('admin.informacoes.edit', $informacao) }}" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/botao-editar.png') }}" alt="Editar"/></a>
                                <form action="{{ route('admin.informacoes.destroy', $informacao) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm botaoTab"><img class="imgBtn" src="{{ asset('assets/img/botoes/paraTabelas/excluir.png') }}" alt="Excluir"/></button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p>Nenhuma informação encontrada.</p>
            </div>
        @endforelse
    </div>
    
    @if($informacoes->hasPages())
        <div class="d-flex justify-content-center">
            {{ $informacoes->links() }}
        </div>
    @endif
@endsection
