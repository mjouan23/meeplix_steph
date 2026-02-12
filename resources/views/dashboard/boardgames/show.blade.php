@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>{{ $boardgame->name }}</h1>

    @if($boardgame->image)
        <img src="{{ asset('storage/' . $boardgame->image) }}" class="img-fluid mb-4" width="300">
    @endif

    <a href="{{ route('dashboard.boardgames.index') }}" class="btn btn-secondary">← Retour</a>
</div>
@endsection
