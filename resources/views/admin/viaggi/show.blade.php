@auth

@extends('layouts.app')

@section('content')

<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('videos/loop1.mp4') }}" type="video/mp4">
    </video>
</div>
<div class="header-section">
    <h3>{{ $viaggio->titolo }}</h3>
</div>

<div class="container my-4">
    
    @if($viaggio->immagine)
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $viaggio->immagine) }}" alt="Immagine Viaggio" class="img-fluid rounded" style="max-width: 80%;">
        </div>
    @else
        <p class="text-center text-muted">Nessuna Immagine disponibile</p>
    @endif

    <!-- Contenitore Flex per le informazioni e l'itinerario con dimensioni limitate -->
    <div class="d-flex flex-column flex-lg-row gap-4 mt-4">
        <!-- Inizio della sezione informazioni con dimensioni limitate -->
        <div class="card flex-fill" style="max-width: 500px;">
            <div class="card-header">
                <h4><i class="fas fa-info-circle"></i> Informazioni sul Viaggio</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <p><i class="fas fa-map-marker-alt"></i> <strong>Meta:</strong> {{ $viaggio->meta }}</p>
                    </div>
                    <div class="col-12 mb-2">
                        <p><i class="fas fa-clock"></i> <strong>Durata:</strong> {{ $viaggio->durata }} giorni</p>
                    </div>
                    <div class="col-12 mb-2">
                        <p class="card-text">
                            <i class="fas fa-calendar-alt"></i> <strong>Data Inizio:</strong> {{ $viaggio->data_inizio }}
                        </p>
                        <p class="card-text">
                            <i class="fas fa-calendar-alt"></i> <strong>Data Fine:</strong> {{ $viaggio->data_fine }}
                        </p>
                    </div>
                    <div class="col-12 mb-2">
                        <p><i class="fas fa-info-circle"></i> <strong>Dettagli:</strong> {{ $viaggio->dettagli }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fine della sezione informazioni -->

        <!-- Inizio della sezione itinerario -->
        <div class="card info-box"> <!-- Usa la classe info-box per mantenere lo stile -->
            <div class="card-header">
                <h4><i class="fas fa-route"></i> Itinerario</h4>
            </div>
            <div class="card-body">
                <ul class="list-group itinerary-list">
                    @if($viaggio->giornate && $viaggio->giornate->isNotEmpty())
                        @foreach($viaggio->giornate as $giornata)
                            <li class="list-group-item">
                                <div class="giornata-details">
                                    <span class="giornata-date"><i class="fas fa-calendar-day"></i> {{ $giornata->data }}</span>
                                    <ul class="list-group tappe-list">
                                        @if($giornata->tappe && $giornata->tappe->isNotEmpty())
                                            @foreach($giornata->tappe as $tappa)
                                                <li class="list-group-item tappa-item">{{ $tappa->titolo }}: {{ $tappa->descrizione }}</li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">Nessuna tappa disponibile</li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">Nessuna giornata disponibile</li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- Fine della sezione itinerario -->
            </div>

    <div class="mt-4 text-center">
        <a href="{{ route('admin.viaggi.edit', $viaggio->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Modifica</a>
        <a href="{{ route('admin.viaggi.index') }}" class="btn btn-secondary"><i class="fas fa-list"></i> Torna alla lista</a>
    </div>
</div>
@endsection
@endauth