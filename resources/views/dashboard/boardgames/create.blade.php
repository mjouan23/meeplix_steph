@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Ajouter un jeu</h1>

    <form action="{{ route('dashboard.boardgames.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Acronyme</label>
            <input type="text" name="acronym" class="form-control" value="{{ old('acronym') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
    </form>
</div>
@endsection
