@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifica Viaggio</h1>

        <form action="{{ route('viaggi.update', $viaggio->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="titolo" value="{{ $viaggio->titolo }}" required>
            </div>

            <div class="mb-3">
                <label for="descrizione" class="form-label">Descrizione</label>
                <textarea class="form-control" id="descrizione" name="descrizione" rows="3">{{ $viaggio->descrizione }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Aggiorna Viaggio</button>
        </form>

        <a href="{{ route('viaggi.show', $viaggio->id) }}" class="btn btn-secondary mt-3">Annulla</a>
    </div>
@endsection