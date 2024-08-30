@auth
@extends('layouts.app')

@section('content')

<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('videos/loop3.mp4') }}" type="video/mp4">
    </video>
</div> 

<div class="header-section">
    <h3> Qui puoi creare un nuovo viaggio</h3>
</div>

<div class="container my-4">

    <form action="{{ route('admin.viaggi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Row per affiancare i due box -->
        <div class="row custom-gap">
            <!-- Informazioni sul Viaggio -->
            <div class="col-lg-6">
                <div class="card info-box">
                    <div class="card-header">
                        <h4><i class="fas fa-info-circle"></i> Informazioni sul Viaggio</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="titolo"><i class="fas fa-pen"></i> Nome dell'avventura</label>
                            <input type="text" class="form-control" id="titolo" name="titolo" value="{{ old('titolo') }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="meta"><i class="fas fa-map-marker-alt"></i> Meta</label>
                            <input type="text" class="form-control" id="meta" name="meta" value="{{ old('meta') }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="durata"><i class="fas fa-clock"></i> Durata (giorni)</label>
                            <input type="number" class="form-control" id="durata" name="durata" value="{{ old('durata') }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="periodo"><i class="fas fa-calendar-alt"></i> Periodo</label>
                            <select type="periodo" class="form-control" id="periodo" name="periodo" required>
                                <option value="" disabled {{ old('periodo') ? '' : 'selected' }}>Seleziona un periodo</option>
                                <option value="Estate" {{ old('periodo') == 'Estate' ? 'selected' : '' }}>Estate</option>
                                <option value="Autunno" {{ old('periodo') == 'Autunno' ? 'selected' : '' }}>Autunno</option>
                                <option value="Primavera" {{ old('periodo') == 'Primavera' ? 'selected' : '' }}>Primavera</option>
                                <option value="Inverno" {{ old('periodo') == 'Inverno' ? 'selected' : '' }}>Inverno</option>
                            </select>
                        </div>
                        <div class="form-group mb-2 overlay-container">
                            <label for="dettagli"><i class="fas fa-info-circle"></i> Dettagli</label>
                            <textarea class="form-control" id="dettagli" name="dettagli">{{ old('dettagli') }}</textarea>
                            <!-- Questo div fungerà da overlay per il contatore di caratteri -->
                            <div class="char-count"> / 500 caratteri</div>
                        </div>
                        <div class="form-group mb-2">
                            <input type="file" class="form-control" id="immagine" name="immagine">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Itinerario -->
            <div class="col-lg-6">
                <div class="card info-box">
                    <div class="card-header">
                        <h4><i class="fas fa-calendar-day"></i> Itinerario</h4>
                    </div>
                    <div class="card-body">
                        <div id="giornate-container">
                            <div class="giornata mb-3">
                                <div class="form-group">
                                    <label for="giornate[0][data]">Data Giornata</label>
                                    <input type="date" class="form-control mb-2" name="giornate[0][data]" required>
                                </div>
                                <div class="tappe-container">
                                    <div class="form-group">
                                        <label for="giornate[0][tappe][0][titolo]">Tappa 1</label>
                                        <input type="text" class="form-control mb-2" name="giornate[0][tappe][0][titolo]" placeholder="Titolo Tappa">
                                        <textarea type="text" class="form-control mb-2" name="giornate[0][tappe][0][descrizione]" placeholder="Descrizione Tappa"></textarea>
                                    </div>
                                     <!-- Aggiungi il pulsante "Rimuovi Tappa" -->
                                     <button type="button" class="btn btn-primary remove-tappa-button mb-2">Rimuovi Tappa</button>
                                </div>
                                <button type="button" class="btn btn-primary add-tappa-button" data-giornata-index="0">Aggiungi Tappa</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mb-2" id="add-giornata-button"><i class="fas fa-plus"></i></button>
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