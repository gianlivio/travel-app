@auth
@extends('layouts.app')

@section('content')

<div class="header-section">
    <h1 class="display-4 text-center mb-5">Modifica Viaggio</h1>
    <h3> Qui puoi gestire i dettagli del tuo viaggio</h3>
</div>

<div class="container my-4">
    

    <form action="{{ route('admin.viaggi.update', $viaggio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Row per affiancare i due box -->
        <div class="row custom-gap">
            <!-- Informazioni sul Viaggio -->
            <div class="col-lg-6">
                <div class="card info-box">
                    <div class="card-header">
                        <h4><i class="fas fa-info-circle"></i> Informazioni sul Viaggio</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="titolo"><i class="fas fa-pen"></i> Nome dell'avventura</label>
                            <input type="text" class="form-control" id="titolo" name="titolo" value="{{ $viaggio->titolo }}" required>
                        </div>
                        <div class="form-group">
                            <label for="meta"><i class="fas fa-map-marker-alt"></i> Meta</label>
                            <input type="text" class="form-control" id="meta" name="meta" value="{{ $viaggio->meta }}" required>
                        </div>
                        <div class="form-group">
                            <label for="durata"><i class="fas fa-clock"></i> Durata (giorni)</label>
                            <input type="number" class="form-control" id="durata" name="durata" value="{{ $viaggio->durata }}" required>
                        </div>
                        <div class="form-group">
                            <label for="periodo"><i class="fas fa-calendar-alt"></i> Periodo</label>
                            <select class="form-control" id="periodo" name="periodo" required>
                                <option value="" disabled>Seleziona un periodo</option>
                                <option value="Estate" {{ $viaggio->periodo == 'Estate' ? 'selected' : '' }}>Estate</option>
                                <option value="Autunno" {{ $viaggio->periodo == 'Autunno' ? 'selected' : '' }}>Autunno</option>
                                <option value="Primavera" {{ $viaggio->periodo == 'Primavera' ? 'selected' : '' }}>Primavera</option>
                                <option value="Inverno" {{ $viaggio->periodo == 'Inverno' ? 'selected' : '' }}>Inverno</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dettagli"><i class="fas fa-info-circle"></i> Dettagli</label>
                            <textarea class="form-control" id="dettagli" name="dettagli">{{ $viaggio->dettagli }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="immagine"><i class="fas fa-image"></i> Carica Nuova Immagine</label>
                            <input type="file" class="form-control" id="immagine" name="immagine">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Itinerario -->
            <div class="col-lg-6">
                <div class="card info-box">
                    <div class="card-header">
                        <h4><i class="fas fa-route"></i> Itinerario</h4>
                    </div>
                    <div class="card-body">
                        <div id="itinerary-container">
                            <!-- Visualizza tappe esistenti -->
                            @foreach($viaggio->tappe as $index => $tappa)
                                <div class="form-group">
                                    <label for="tappa_{{ $index + 1 }}">Tappa {{ $index + 1 }}</label>
                                    <input type="text" class="form-control mb-3" id="tappa_{{ $index + 1 }}" name="tappe[]" value="{{ $tappa->descrizione }}" placeholder="Descrizione Tappa {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-step-button" class="btn btn-secondary mb-3"><i class="fas fa-plus"></i> Aggiungi Tappa</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pulsanti di Azione -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salva </button>
            <a href="{{ route('admin.viaggi.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Annulla</a>
        </div>
    </form>
</div>

@endsection
@endauth