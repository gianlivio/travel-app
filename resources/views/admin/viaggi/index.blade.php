@auth
@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1 class="mb-4 text-center">Diario di Viaggio</h1>
        
        <!-- Griglia di Card -->
        <div class="row">
            @foreach($viaggi as $viaggio)
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        @if($viaggio->image)
                            <img src="{{ asset('storage/' . $viaggio->image) }}" class="card-img-top" alt="Immagine Viaggio">
                        @else
                            <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="Nessuna Immagine">
                        @endif
                        <div class="card-body card-content">
                            <h5 class="card-title">
                                <i class="fas fa-map-signs"></i> {{ $viaggio->titolo }}
                            </h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt"></i> <strong> Meta:</strong> {{ $viaggio->meta }}
                            </p>
                            <p class="card-text">
                                <i class="fas fa-clock"></i> <strong> Durata:</strong> {{ $viaggio->durata }} giorni
                            </p>
                            <p class="card-text">
                                <i class="fas fa-calendar-alt"></i> <strong> Periodo:</strong> {{ $viaggio->periodo }}
                            </p>
                            <p class="card-text">
                                <i class="fas fa-align-left"></i> <strong> Dettagli:</strong> {{ $viaggio->dettagli }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-start">
                                <span class="crud-icon me-2" title="Visualizza">
                                    <a href="{{ route('admin.viaggi.show', $viaggio->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </span>
                                <span class="crud-icon me-2" title="Modifica">
                                    <a href="{{ route('admin.viaggi.edit', $viaggio->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </span>
                                <span class="crud-icon" title="Elimina">
                                    <form action="{{ route('admin.viaggi.destroy', $viaggio->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mb-4">
            <a href="{{ route('admin.viaggi.create') }}" class="btn btn-success">Crea Nuova Avventura</a>
        </div>
    </div>
@endsection
@else
    <script>window.location.href = '{{ route('login') }}';</script>
@endauth