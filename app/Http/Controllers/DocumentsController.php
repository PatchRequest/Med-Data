<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentsController extends Controller {

    public function index() {
        return Inertia::render('Documents/Index');
    }

    public function create() {
    }

    public function store(Request $request) {
    }

    public function show(Document $document) {
    }

    public function edit(Document $document) {
    }

    public function update(Request $request, Document $document) {
    }

    public function destroy(Document $document) {
    }

    public function share(User $doctor) {

        return Inertia::render('Documents/Share', compact('doctor'));

    }

}
