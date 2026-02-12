<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Boardgame;
use App\Models\User;


class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parties = Party::with(['boardgame', 'players'])->latest()->paginate(10);
        return view('parties.index', compact('parties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $boardgame = null;
        if ($request->has('boardgame_id')) {
            $boardgame = Boardgame::findOrFail($request->boardgame_id);
        }
        $users = User::all();
        return view('parties.create', compact('boardgame', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'boardgame_id' => 'required|exists:boardgames,id',
            'played_at' => 'required|date',
            'name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'players' => 'required|array|min:1',
            'scores' => 'required|array',
            'winner' => 'required|exists:users,id'
        ]);

        $party = Party::create($validated);

        foreach ($request->players as $playerId) {
            $party->players()->attach($playerId, [
                'score' => $request->scores[$playerId] ?? null,
                'winner' => $playerId == $request->winner
            ]);
        }

        return redirect()->route('boardgames.show', $party->boardgame_id)
                ->with('success', 'Partie enregistrée. Retour au jeu.');
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     $party->load(['boardgame', 'players']);
    //     return view('parties.show', compact('party'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
