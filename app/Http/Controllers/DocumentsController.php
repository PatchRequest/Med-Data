<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Share;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class DocumentsController extends Controller {

    public function index() {
        /** @var LengthAwarePaginator $documents */
        $documents = Document::whereOwnerId(auth()->id())->with('share.recipient')->paginate(20);
        $meta = collect($documents->toArray())->except(['data']);


        return Inertia::render('Documents/Index', compact('documents', 'meta'));
    }

    public function create(User $doctor) {
        return Inertia::render('Documents/Share', compact('doctor'));
    }

    public function store(Request $request, User $doctor) {
        abort_if(!$doctor->is_doctor, 403);

        $data = $request->validate([
            'message' => ['nullable', 'string', 'min:10'],
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file'],
        ]);

        $share = new Share([
            'creator_id' => auth()->id(),
            'recipient_id' => $doctor->id,
        ]);
        $saved = $share->save();

        abort_if(!$saved, 412, 'Could not save share');

        $share = $share->refresh();
        $uploadId = $share->id;

        /** @var UploadedFile $file */
        foreach ($data['files'] as $file) {
            $document = new Document([
                'path' => $file->storeAs('documents' . DIRECTORY_SEPARATOR . auth()->id() . DIRECTORY_SEPARATOR . $uploadId, $file->getClientOriginalName()),
                'owner_id' => auth()->id(),
                'share_id' => $share->id,
            ]);
            $document->save();
        }

        return redirect()->route('documents.index')->with('message', 'Erfolgreich geteilt');
    }

    public function show(Document $document) {
        abort_unless($document->share->recipient_id === auth()->id() || $document->share->creator_id === auth()->id(), 403);

        return \Storage::download($document->path);
    }

    public function edit(Document $document) {
    }

    public function update(Request $request, Document $document) {
    }

    public function destroy(Document $document) {
        abort_unless($document->share->recipient_id === auth()->id() || $document->share->creator_id === auth()->id(), 403);

        $share = $document->share;
        $document->delete();
        $share = $share->fresh('documents');
        if($share->documents_count === 0){
            $share->delete();
        }

        return redirect()->route('documents.index')->with('message', 'Erfolgreich gelöscht');
    }

}
