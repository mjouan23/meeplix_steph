{{-- resources/views/parties/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nouvelle partie</h2>
    
    <form action="{{ route('parties.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label>Jeu</label>
            @if($boardgame)
                <input type="text" class="form-control" value="{{ $boardgame->name }}" readonly>
                <input type="hidden" name="boardgame_id" value="{{ $boardgame->id }}">
            @else
                <select name="boardgame_id" class="form-select" required>
                    @foreach($boardgames as $boardgame)
                        <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="mb-3">
            <label>Date et heure</label>
            <input type="datetime-local" name="played_at" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Joueurs</label>
            <div id="players-container">
                @foreach($users as $user)
                    <div class="d-flex gap-2 mb-2">
                        <div class="form-check">
                            <input type="checkbox" name="players[]" value="{{ $user->id }}" class="form-check-input">
                            <label class="form-check-label">{{ $user->name }}</label>
                        </div>
                        <input type="number" name="scores[{{ $user->id }}]" class="form-control form-control-sm w-auto" placeholder="Score">
                        <div class="form-check">
                            <input type="radio" name="winner" value="{{ $user->id }}" class="form-check-input">
                            <label class="form-check-label">Gagnant</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection