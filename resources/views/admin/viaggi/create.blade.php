@auth
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crea Nuovo Viaggio</h1>
    
    <form action="{{ route('admin.viaggi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="titolo">Nome dell'avventura</label>
            <input type="text" class="form-control" id="titolo" name="titolo" value="{{ old('titolo') }}" required>
        </div>
        
        <div class="form-group">
            <label for="meta">Meta</label>
            <input type="text" class="form-control" id="meta" name="meta" value="{{ old('meta') }}" required>
        </div>
        
        <div class="form-group">
            <label for="durata">Quanti giorni?</label>
            <input type="number" class="form-control" id="durata" name="durata" value="{{ old('durata') }}" required>
        </div>
        
        <div class="form-group">
            <label for="periodo">Periodo</label>
            <select class="form-control" id="periodo" name="periodo" required>
                <option value="" disabled selected>Seleziona un periodo</option>
                <option value="Estate">Estate</option>
                <option value="Autunno">Autunno</option>
                <option value="Primavera">Primavera</option>
                <option value="Inverno">Inverno</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="dettagli">Dettagli</label>
            <textarea class="form-control" id="dettagli" name="dettagli" placeholder="Racconta il tuo itinerario..">{{ old('dettagli') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="immagine">Carica Immagine</label>
            <input type="file" class="form-control" id="immagine" name="immagine">
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Crea Viaggio</button>
            <a href="{{ route('admin.viaggi.index') }}" class="btn btn-secondary">Torna Indietro</a>
        </div>
    </form>
</div>
@endsection
@else
    <script>window.location.href = '{{ route('login') }}';</script>
@endauth