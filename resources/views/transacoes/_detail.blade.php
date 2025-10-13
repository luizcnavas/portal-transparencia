<div>
    <h5>{{ $item->descricao }}</h5>
    <p>Tipo: <strong>{{ ucfirst($item->tipo) }}</strong></p>
    <p>Valor: <strong class="{{ $item->tipo === 'receita' ? 'text-success' : 'text-danger' }}">R$ {{ number_format($item->valor, 2, ',', '.') }}</strong></p>
    <p>Data: <strong>{{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }}</strong></p>

    @if($item->source === 'documento' && isset($item->documento))
        {{-- Se vier de um documento, mostrar links de visualização/download --}}
        <hr />
        <p>Arquivo: <a href="{{ route('documentos.preview', ['documento' => $item->documento->id]) }}">Visualizar</a> | <a href="{{ route('documentos.download', ['documento' => $item->documento->id]) }}">Download</a></p>
    @endif
</div>
