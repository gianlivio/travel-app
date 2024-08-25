@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center" style="font-family: 'Lato', sans-serif;">Pianifica una Nuova Avventura</h1>
    
    <!-- Form per creare un nuovo viaggio -->
    <form action="{{ route('viaggi.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded" style="background-color: rgba(255, 255, 255, 0.8); font-family: 'Roboto', sans-serif;">
        @csrf
        
        <div class="form-group mb-3">
            <label for="titolo" class="form-label">Nome dell'avventura</label>
            <input type="text" class="form-control" id="titolo" name="titolo" placeholder="Inserisci il nome dell'avventura" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="meta" class="form-label">Itinerario</label>
            <input type="text" class="form-control" id="meta" name="meta" placeholder="Inserisci la meta" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="durata" class="form-label">Quanti giorni?</label>
            <input type="number" class="form-control" id="durata" name="durata" placeholder="Inserisci la durata in giorni" required>
        </div>
        
        <div class="form-group mb-3">
            <label for="periodo" class="form-label">Periodo</label>
            <select class="form-control" id="periodo" name="periodo" required>
                <option value="" disabled selected>Seleziona un periodo</option>
                <option value="Estate">Estate</option>
                <option value="Autunno">Autunno</option>
                <option value="Primavera">Primavera</option>
                <option value="Inverno">Inverno</option>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="dettagli" class="form-label">Dettagli</label>
            <textarea class="form-control" id="dettagli" name="dettagli" rows="5" placeholder="Descrivi l'itinerario..."></textarea>
        </div>
        
        <div class="form-group mb-4">
            <label for="image" class="form-label">Immagine</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Crea Avventura</button>
            <a href="{{ route('viaggi.index') }}" class="btn btn-secondary">Annulla</a>
        </div>
    </form>
</div>
@endsection