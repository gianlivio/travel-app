@auth

@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h1 class="display-4 text-center mb-5">{{ $viaggio->titolo }}</h1>
    
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
                        <p><i class="fas fa-calendar-alt"></i> <strong>Periodo:</strong> {{ $viaggio->periodo }}</p>
                    </div>
                    <div class="col-12 mb-2">
                        <p><i class="fas fa-info-circle"></i> <strong>Dettagli:</strong> {{ $viaggio->dettagli }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fine della sezione informazioni -->

        <!-- Inizio della sezione itinerario con dimensioni limitate -->
        <div class="card flex-fill" style="max-width: 500px;">
            <div class="card-header">
                <h4><i class="fas fa-route"></i> Itinerario</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($viaggio->tappe as $tappa)
                        <li class="list-group-item"><i class="fas fa-map-signs"></i> {{ $tappa->descrizione }}</li>
                    @endforeach
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