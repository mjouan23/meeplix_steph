@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($boardgames as $boardgame)
            <div class="col-md-4 d-flex justify-content-center">
                <div class="card" style="width: 18rem;">
                    <div class="card-img-top-wrapper">
                        <img src="{{ asset('storage/' . $boardgame->image) }}" class="card-img-top" alt="{{ $boardgame->name }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $boardgame->name }}</h5>
                        <a href="{{ route('boardgames.show', $boardgame) }}" class="btn btn-primary">Jouer</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
