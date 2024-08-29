@auth
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifica Avventura</h1>
    
    <form action="{{ route('admin.viaggi.update', $viaggio->id) }}" method="POST" enctype="multipart/form-data">
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
            <label for="immagine">Carica Nuova Immagine</label>
            <input type="file" class="form-control" id="immagine" name="immagine">
        </div>

        <!-- Sezione Itinerario -->
        <div id="itinerary-container">
            <h4>Itinerario</h4>
            @foreach($viaggio->tappe as $index => $tappa)
                <div class="form-group">
                    <label for="tappa_{{ $index + 1 }}">Tappa {{ $index + 1 }}</label>
                    <input type="text" class="form-control" id="tappa_{{ $index + 1 }}" name="tappe[]" value="{{ $tappa->descrizione }}" placeholder="Descrizione Tappa {{ $index + 1 }}">
                </div>
            @endforeach
            <button type="button" id="add-step-button" class="btn btn-secondary mb-3">Aggiungi Tappa</button>
        </div>
        <!-- Fine sezione Itinerario -->

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Salva Modifiche</button>
            <a href="{{ route('admin.viaggi.index') }}" class="btn btn-secondary">Annulla</a>
        </div>
    </form>
</div>

@endsection
@else
    <script>window.location.href = '{{ route('login') }}';</script>
@endauth