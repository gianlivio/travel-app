@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dettagli del Viaggio</h1>
        <h2>{{ $viaggio->titolo }}</h2>
        <p>{{ $viaggio->descrizione }}</p>

        <h3>Giornate</h3>
        <ul class="list-group">
            @foreach($viaggio->giornate as $giornata)
                <li class="list-group-item">
                    <a href="{{ route('giornate.show', $giornata->id) }}">{{ $giornata->data }}</a>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('viaggi.index') }}" class="btn btn-secondary mt-3">Torna alla lista dei viaggi</a>
    </div>
@endsection