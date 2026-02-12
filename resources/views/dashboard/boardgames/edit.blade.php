@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>{{ $boardgame->name }}</h1>

    <form action="{{ route('dashboard.boardgames.update', $boardgame) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $boardgame->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Acronyme</label>
            <input type="text" name="acronym" class="form-control" value="{{ old('acronym', $boardgame->acronym) }}" max=25 required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            @if($boardgame->image)
                <img src="{{ asset('storage/' . $boardgame->image) }}" width="200" class="mt-2">
            @endif
        </div>

        <h5>Fichiers PDF</h5>

        <div class="mb-3 d-flex">
            <input type="file" class="form-control me-2" id="pdf_file_input" accept="application/pdf">
            <input type="text" class="form-control me-2" id="pdf_display_name" placeholder="Nom à afficher">
            <!-- <button type="button" class="btn btn-primary" id="upload_pdf_btn">Ajouter un fichier</button> -->
            <button type="button" class="btn btn-primary" id="upload_pdf_btn" data-upload-url="{{ route('dashboard.boardgames.uploadFile', $boardgame->id) }}">Ajouter</button>
        </div>

        <ul id="existing-files" class="list-group mb-3">
            @foreach ($boardgame->files as $file)
                <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $file->id }}">
                    <span>{{ $file->display_name }}</span>
                    <!-- <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="btn btn-sm btn-secondary">Voir</a> -->
                     <div class="btn-group">
                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                        class="btn btn-outline-secondary btn-sm" title="Voir">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm delete-file-btn" title="Supprimer"
                                data-id="{{ $file->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
<!-- Modal de confirmation -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer le fichier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce fichier PDF ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>
@endsection

