@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $viaggio->titolo }}</h1>
    <div class="mb-4">
        @if($viaggio->image)
            <img src="{{ asset('storage/' . $viaggio->image) }}" alt="Immagine Viaggio" style="width: 300px; height: auto;">
        @else
            Nessuna Immagine disponibile
        @endif
    </div>
    <p><strong>Meta:</strong> {{ $viaggio->meta }}</p>
    <p><strong>Durata:</strong> {{ $viaggio->durata }} giorni</p>
    <p><strong>Periodo:</strong> {{ $viaggio->periodo }}</p>
    <p><strong>Dettagli:</strong> {{ $viaggio->dettagli }}</p>

    <!-- Bottoni di azione con distanza dal contenuto -->
    <div class="mt-4">
        <a href="{{ route('viaggi.index') }}" class="btn btn-secondary">Torna Indietro</a>
        <a href="{{ route('viaggi.edit', $viaggio->id) }}" class="btn btn-warning">Modifica</a>
    </div>
</div>
@endsection