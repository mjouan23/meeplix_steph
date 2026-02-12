@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Utilisateurs</h2>
        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">Créer un nouvel utilisateur</a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($users->isEmpty())
                <p class="p-3 mb-0">Aucun utilisateur trouvé.</p>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Créé le</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ ($user->first_name ?? '') . ' ' . ($user->last_name ?? $user->name) }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ?? '-' }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection