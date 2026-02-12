@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des jeux</h1>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('dashboard.boardgames.create') }}" class="btn btn-success">Ajouter un jeu</a>
        @endif
    </div>

     <!-- Message de confirmation de Suppression -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th style="width: 15%;">Image</th>
                <th style="width: 15%;">Acronyme</th>
                <th style="width: 50%;">Nom</th>
                <th style="width: 20%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($boardgames as $boardgame)
                <tr>
                    <td>
                        @if($boardgame->image)
                            <img src="{{ asset('storage/' . $boardgame->image) }}" alt="{{ $boardgame->name }}" class="img-thumbnail"  width="100" alt="image">
                        @endif
                    </td>
                    <td>{{ $boardgame->acronym }}</td>
                    <td>{{ $boardgame->name }}</td>
                    <td>
                        <a href="{{ route('dashboard.boardgames.edit', $boardgame) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @if (auth()->user()->isAdmin())
                            <form action="{{ route('dashboard.boardgames.destroy', $boardgame) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce jeu ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
