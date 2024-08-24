@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crea un Nuovo Viaggio</h1>

        <form action="{{ route('viaggi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="titolo" required>
            </div>

            <div class="mb-3">
                <label for="descrizione" class="form-label">Descrizione</label>
                <textarea class="form-control" id="descrizione" name="descrizione" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Salva Viaggio</button>
        </form>
    </div>
@endsection