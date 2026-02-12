<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Boardgame;
use App\Models\BoardgameFile;

use Illuminate\Support\Facades\Storage;

class BoardgameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $boardgames = Boardgame::all();
        // return view('boardgames.index', compact('boardgames'));

        $boardgames = Boardgame::orderBy('created_at', 'desc')->get();

        // Si dans /dashboard/boardgames, utiliser la vue admin ou modérateur
        if (auth()->check() && (auth()->user()->isModerator() || auth()->user()->isAdmin()) ) {
            return view('dashboard.boardgames.index', compact('boardgames'));
        }
        // Sinon mire de connexion
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.boardgames.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'acronym' => 'nullable|string|max:25',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);

        if ($request->hasFile('image')) {
            // $request->file('image') : Récupère le fichier envoyé dans le champ image et retourne une instance de UploadedFile
            // store('bandes', 'public') : Stocke le fichier dans le dossier storage/app/public/bandes (cf. config/filesystems.php)
            $imagePath = $request->file('image')->store('boardgame', 'public');
        }
        
        Boardgame::create([
            'name' => $request->input('name'),
            'acronym' => $request->input('acronym'),
            'image' => $imagePath ?? null
        ]);

        return redirect()->route('dashboard.boardgames.index')->with('success', 'Jeu créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Boardgame $boardgame)
    {
        // Si dans /dashboard/boardgames, utiliser la vue admin ou modérateur
        if (auth()->check() && (auth()->user()->isModerator() || auth()->user()->isAdmin()) ) {
            return view('dashboard.boardgames.show', compact('boardgame'));
        }
        // Sinon mire de connexion
        return view('login');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        // Récupérer la bande dessinée par son ID
        $boardgame = Boardgame::findOrFail($id);

        return view('dashboard.boardgames.edit', compact('boardgame'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'acronym' => 'string|max:25',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Récupérer la bande dessinée par son ID
        $boardgame = Boardgame::findOrFail($id);
        
        // Vérifie si un fichier a bien été envoyé via le champ image
        if ($request->hasFile('image')) {
            // $request->file('image') : Récupère le fichier envoyé dans le champ image et retourne une instance de UploadedFile
            // store('bandes', 'public') : Stocke le fichier dans le dossier storage/app/public/bandes (cf. config/filesystems.php)
            $imagePath = $request->file('image')->store('boardgame', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Sinon, ne pas écraser l'image existante
            unset($validated['image']);
        }

        // Mettre à jour les données
        $boardgame->update($validated);

        // // Gérer les fichiers PDF uploadés
        // if ($request->has('pdf_files')) {
        //     foreach ($request->file('pdf_files') as $index => $file) {
        //         $filePath = $file->store('boardgame_pdfs', 'public');

        //         BoardgameFile::create([
        //             'boardgame_id' => $boardgame->id,
        //             'display_name' => $request->input('pdf_display_names')[$index] ?? $file->getClientOriginalName(),
        //             'file_path' => $filePath,
        //             'display_order' => $index,
        //         ]);
        //     }
        // }

        // // Met à jour l’ordre d’affichage
        // if ($request->has('existing_file_order')) {
        //     foreach ($request->input('existing_file_order') as $order => $fileId) {
        //         BoardgameFile::where('id', $fileId)->update(['display_order' => $order]);
        //     }
        // }

        return redirect()->route('dashboard.boardgames.index')->with('success', 'Jeu mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boardgame $boardgame)
    {
        $boardgame->delete();
        return redirect()->route('dashboard.boardgames.index')->with('success', 'Jeu supprimé avec succès.');
    }

    /**
     * Upload a PDF file for a boardgame.
     */
    public function uploadFile(Request $request, Boardgame $boardgame)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:5120',
            'display_name' => 'required|string|max:255',
        ]);

        $path = $request->file('pdf_file')->store('boardgame_pdfs', 'public');

        $order = $boardgame->files()->max('display_order') + 1;

        $file = $boardgame->files()->create([
            'display_name' => $request->input('display_name'),
            'file_path' => $path,
            'display_order' => $order,
        ]);

        return response()->json([
            'success' => true,
            'file' => [
                'id' => $file->id,
                'display_name' => $file->display_name,
                'url' => Storage::url($file->file_path),
            ]
        ]);
    }

    /**
     * Delete PDF file for a boardgame
     */
    public function destroyFile(BoardgameFile $file)
    {
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return response()->json(['success' => true]);
    }

}
