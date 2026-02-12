{{-- resources/views/boardgames/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div id="boardgame-{{ $boardgame->acronym }}" class="main-boardgame container">
        @includeIf('boardgames.partials.' . $boardgame->acronym)
        @if ($boardgame->files->isNotEmpty())
            <button id="scroll-to-boardgame-settings" class="btn btn-primary rounded-circle position-absolute start-50 translate-middle-x bottom-0 mb-3">
                <i class="bi bi-chevron-double-down fs-3"></i>
            </button>
        @endif
    </div>

    <div id="boardgame-{{ $boardgame->acronym }}-settings" class="main-boardgame-settings container my-5">
        <!-- bouton de scroll to top -->
        <div class="text-center">
            <button id="scroll-to-boardgame" class="btn btn-secondary rounded-circle mb-5 w-auto mx-auto">
                <i class="bi bi-chevron-double-up fs-3"></i>
            </button>
        </div>

        <!-- Parties -->
        <div id="boardgame-{{ $boardgame->acronym }}-party" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Historique des parties</h5>
                <a href="{{ route('parties.create', ['boardgame_id' => $boardgame->id]) }}" class="btn btn-primary">
                    Nouvelle partie
                </a>
            </div>
            @if($parties->isEmpty())
                <p class="text-muted">Aucune partie enregistrée pour ce jeu.</p>
            @else
                <div class="list-group">
                    @foreach($parties as $party)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-1">
                                    {{ $party->played_at->format('d/m/Y H:i') }}
                                    @if($party->name)
                                        - {{ $party->name }}
                                    @endif
                                </h5>
                            </div>
                            <p class="mb-1">Joueurs : 
                                @foreach($party->players as $player)
                                    <span class="badge {{ $player->pivot->winner ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $player->name }}
                                        @if($player->pivot->score !== null)
                                            ({{ $player->pivot->score }})
                                        @endif
                                    </span>
                                @endforeach
                            </p>
                            @if($party->notes)
                                <small class="text-muted">{{ $party->notes }}</small>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $parties->links() }}
                </div>
            @endif
        </div>

        <!-- Fichiers -->
        @if ($boardgame->files->isNotEmpty())
            <div id="boardgame-{{ $boardgame->acronym }}-file">
    
                <h5 class="mb-3">Télécharger les fichiers</h5>
    
                <ul class="list-group">
                    @foreach ($boardgame->files as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                                {{ $file->display_name }}
                            </div>
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm" title="Télécharger">
                                <i class="bi bi-download"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

@endsection


@push('styles')
    @vite("resources/css/boardgames/{$boardgame->acronym}.css")
@endpush

@push('scripts')
    @if ($boardgame->files->isNotEmpty())
        <script>
        document.getElementById('scroll-to-boardgame-settings').addEventListener('click', () => {
            document.getElementById('boardgame-{{ $boardgame->acronym }}-settings').scrollIntoView({ behavior: 'smooth' });
        });

        document.getElementById('scroll-to-boardgame').addEventListener('click', () => {
            // document.getElementById('boardgame-{{ $boardgame->acronym }}').scrollIntoView({ behavior: 'smooth' });
            window.scrollTo({ top: 0, behavior: 'smooth'});
        });
        </script>
    @endif
    @vite("resources/js/boardgames/{$boardgame->acronym}.js")
@endpush