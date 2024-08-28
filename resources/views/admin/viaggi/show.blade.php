@auth
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $viaggio->titolo }}</h1>
    <div class="mb-4">
        @if($viaggio->immagine)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $viaggio->immagine) }}" alt="Immagine Viaggio" style="width: 200px; height: auto;">
        </div>
        @endif
            Nessuna Immagine disponibile
        @endif
    </div>
    <p><strong>Meta:</strong> {{ $viaggio->meta }}</p>
    <p><strong>Durata:</strong> {{ $viaggio->durata }} giorni</p>
    <p><strong>Periodo:</strong> {{ $viaggio->periodo }}</p>
    <p><strong>Dettagli:</strong> {{ $viaggio->dettagli }}</p>

    <div class="mt-4">
        <a href="{{ route('admin.viaggi.index') }}" class="btn btn-secondary">Torna Indietro</a>
        <a href="{{ route('admin.viaggi.edit', $viaggio->id) }}" class="btn btn-warning">Modifica</a>
    </div>
</div>
@endsection
@else
    <script>window.location.href = '{{ route('login') }}';</script>
@endauth