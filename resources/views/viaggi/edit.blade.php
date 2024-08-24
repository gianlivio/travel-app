@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifica Avventura</h1>
    
    <!-- Form per modificare un viaggio esistente -->
    <form action="{{ route('viaggi.update', $viaggio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="titolo">Nome dell'avventura</label>
            <input type="text" class="form-control" id="titolo" name="titolo" value="{{ $viaggio->titolo }}" required>
        </div>
        
        <div class="form-group">
            <label for="meta">Meta</label>
            <input type="text" class="form-control" id="meta" name="meta" value="{{ $viaggio->meta }}" required>
        </div>
        
        <div class="form-group">
            <label for="durata">Quanti giorni?</label>
            <input type="number" class="form-control" id="durata" name="durata" value="{{ $viaggio->durata }}" required>
        </div>
        
        <div class="form-group">
            <label for="periodo">Periodo</label>
            <select class="form-control" id="periodo" name="periodo" required>
                <option value="" disabled>Seleziona un periodo</option>
                <option value="Estate" {{ $viaggio->periodo == 'Estate' ? 'selected' : '' }}>Estate</option>
                <option value="Autunno" {{ $viaggio->periodo == 'Autunno' ? 'selected' : '' }}>Autunno</option>
                <option value="Primavera" {{ $viaggio->periodo == 'Primavera' ? 'selected' : '' }}>Primavera</option>
                <option value="Inverno" {{ $viaggio->periodo == 'Inverno' ? 'selected' : '' }}>Inverno</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="dettagli">Dettagli</label>
            <textarea class="form-control" id="dettagli" name="dettagli" placeholder="Racconta il tuo itinerario..">{{ $viaggio->dettagli }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Carica Immagini</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        
        @if($viaggio->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $viaggio->image) }}" alt="Immagine Viaggio" style="width: 200px; height: auto;">
            </div>
        @endif
        
        <!-- Bottoni di azione con distanza dal form -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Salva Modifiche</button>
            <a href="{{ route('viaggi.index') }}" class="btn btn-secondary">Torna Indietro</a>
        </div>
    </form>
</div>
@endsection