<?php

namespace App\Http\Controllers\Pieces;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pieces\StorePieceRequest;
use App\Http\Requests\Pieces\UpdatePieceRequest;
use App\Services\Pieces\PieceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PieceController extends Controller
{
    protected $pieceService;

    public function __construct(PieceService $pieceService)
    {
        $this->pieceService = $pieceService;

        // Middleware des permissions
        $this->middleware('can:viewPiece')->only(['index', 'show', 'search']);
        $this->middleware('can:createPiece')->only(['create', 'store']);
        $this->middleware('can:editPiece')->only(['edit', 'update']);
        $this->middleware('can:deletePiece')->only('destroy');
    }

    public function index(Request $request)
    {
        $pieces = $this->pieceService->paginate($request->all());
        return view('pages.pieces.index', compact('pieces'));
    }

    public function create()
    {
        return view('pages.pieces.create');
    }

    public function store(StorePieceRequest $request)
    {
        $this->pieceService->create($request->validated());
        return redirect()->route('pieces.index')->with('success', 'Pièce créée avec succès !');
    }

    public function show($id)
    {
        $piece = $this->pieceService->find($id);
        return view('pages.pieces.show', compact('piece'));
    }

    public function edit($id)
    {
        $piece = $this->pieceService->find($id);
        return view('pages.pieces.edit', compact('piece'));
    }

    public function update(UpdatePieceRequest $request, $id)
    {
        $this->pieceService->update($id, $request->validated());
        return redirect()->route('pieces.index')->with('success', 'Pièce mise à jour avec succès !');
    }

    public function destroy($id)
    {
        $this->pieceService->delete($id);
        return redirect()->route('pieces.index')->with('success', 'Pièce supprimée avec succès !');
    }

    public function search(Request $request)
    {
        $results = $this->pieceService->search($request->get('query'));
        return response()->json($results);
    }

    public function generateSinglePdf($id)
    {
        if (Gate::denies('viewPiece')) {
            abort(403, 'Accès interdit');
        }

        $pdfPath = $this->pieceService->generateSinglePdf($id);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
