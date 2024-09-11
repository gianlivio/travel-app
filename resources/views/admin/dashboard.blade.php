@extends('layouts.admin')

@section('content')

<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('videos/loop5.mp4') }}" type="video/mp4">
    </video>
</div> 
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('Sei dentro!!') }}

                        
                    </div>
                    <a href="{{ route('admin.viaggi.index') }}" class="btn btn-primary mt-4">Gestisci Viaggi</a>
                </div>
                

            </div>
        </div>
    </div>
@endsection
