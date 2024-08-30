@auth
@extends('layouts.app')

@section('content')

<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('videos/loop2.mp4') }}" type="video/mp4">
    </video>
</div> 

<div class="header-section">
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
                        <div class="form-group mb-2">
                            <label for="titolo"><i class="fas fa-pen"></i> Nome dell'avventura</label>
                            <input type="text" class="form-control" id="titolo" name="titolo" value="{{ old('titolo', $viaggio->titolo) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="meta"><i class="fas fa-map-marker-alt"></i> Meta</label>
                            <input type="text" class="form-control" id="meta" name="meta" value="{{ old('meta', $viaggio->meta) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="durata"><i class="fas fa-clock"></i> Durata (giorni)</label>
                            <input type="number" class="form-control" id="durata" name="durata" value="{{ old('durata', $viaggio->durata) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="periodo"><i class="fas fa-calendar-alt"></i> Periodo</label>
                            <select class="form-control" id="periodo" name="periodo" required>
                                <option value="" disabled>Seleziona un periodo</option>
                                <option value="Estate" {{ old('periodo', $viaggio->periodo) == 'Estate' ? 'selected' : '' }}>Estate</option>
                                <option value="Autunno" {{ old('periodo', $viaggio->periodo) == 'Autunno' ? 'selected' : '' }}>Autunno</option>
                                <option value="Primavera" {{ old('periodo', $viaggio->periodo) == 'Primavera' ? 'selected' : '' }}>Primavera</option>
                                <option value="Inverno" {{ old('periodo', $viaggio->periodo) == 'Inverno' ? 'selected' : '' }}>Inverno</option>
                            </select>
                        </div>
                        <div class="form-group mb-2 overlay-container">
                            <label for="dettagli"><i class="fas fa-info-circle"></i> Dettagli</label>
                            <textarea class="form-control" id="dettagli" name="dettagli">{{ old('dettagli', $viaggio->dettagli ?? '') }}</textarea>
                            <!-- Questo div fungerà da overlay per il contatore di caratteri -->
                            <div class="char-count"> / 500 caratteri</div>
                        </div>
                        <div class="form-group mb-2">
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
                        <h4><i class="fas fa-calendar-day"></i> Itinerario</h4>
                    </div>
                    <div class="card-body">
                        <div id="giornate-container">
                            @if($viaggio->giornate->isNotEmpty())
                                @foreach($viaggio->giornate as $giornataIndex => $giornata)
                                    <div class="giornata mb-3">
                                        <div class="form-group">
                                            <label for="giornate[{{ $giornataIndex }}][data]">Data Giornata</label>
                                            <input type="date" class="form-control mb-2" name="giornate[{{ $giornataIndex }}][data]" value="{{ old("giornate.$giornataIndex.data", $giornata->data) }}" required>
                                            <input type="hidden" name="giornate[{{ $giornataIndex }}][id]" value="{{ $giornata->id }}">
                                        </div>
                                        <div class="tappe-container">
                                            @foreach($giornata->tappe as $tappaIndex => $tappa)
                                                <div class="form-group">
                                                    <label for="giornate[{{ $giornataIndex }}][tappe][{{ $tappaIndex }}][titolo]">Tappa {{ $tappaIndex + 1 }}</label>
                                                    <input type="text" class="form-control mb-2" name="giornate[{{ $giornataIndex }}][tappe][{{ $tappaIndex }}][titolo]" value="{{ old("giornate.$giornataIndex.tappe.$tappaIndex.titolo", $tappa->titolo) }}" placeholder="Titolo Tappa">
                                                    <textarea class="form-control mb-2" name="giornate[{{ $giornataIndex }}][tappe][{{ $tappaIndex }}][descrizione]" placeholder="Descrizione Tappa">{{ old("giornate.$giornataIndex.tappe.$tappaIndex.descrizione", $tappa->descrizione) }}</textarea>
                                                    <input type="hidden" name="giornate[{{ $giornataIndex }}][tappe][{{ $tappaIndex }}][id]" value="{{ $tappa->id }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-secondary add-tappa-button" data-giornata-index="{{ $giornataIndex }}">Aggiungi Tappa</button>
                                    </div>
                                @endforeach
                            @else
                                <!-- Inizializza con una giornata e una tappa vuota se non ci sono giornate esistenti -->
                                <div class="giornata mb-3">
                                    <div class="form-group">
                                        <label for="giornate[0][data]">Data Giornata</label>
                                        <input type="date" class="form-control mb-2" name="giornate[0][data]" required>
                                    </div>
                                    <div class="tappe-container">
                                        <div class="form-group">
                                            <label for="giornate[0][tappe][0][titolo]">Tappa 1</label>
                                            <input type="text" class="form-control mb-2" name="giornate[0][tappe][0][titolo]" placeholder="Titolo Tappa">
                                            <textarea class="form-control mb-2" name="giornate[0][tappe][0][descrizione]" placeholder="Descrizione Tappa"></textarea>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary add-tappa-button" data-giornata-index="0">Aggiungi Tappa</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-primary mt-3" id="add-giornata-button"><i class="fas fa-plus"></i> Aggiungi Giornata</button>
                        
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