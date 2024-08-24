@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dettagli del Viaggio</h1>
        <h2>{{ $viaggio->titolo }}</h2>
        <p>{{ $viaggio->descrizione }}</p>

        <!-- Puoi aggiungere qui ulteriori dettagli specifici per il viaggio -->

        <a href="{{ route('viaggi.index') }}" class="btn btn-secondary mt-3">Torna alla lista dei viaggi</a>
        <a href="{{ route('viaggi.edit', $viaggio->id) }}" class="btn btn-primary mt-3">Modifica Viaggio</a>
    </div>
@endsection