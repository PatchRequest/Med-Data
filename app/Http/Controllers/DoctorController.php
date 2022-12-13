<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class DoctorController extends Controller {

    public function index() {
        $doctors = User::whereIsDoctor(true)->paginate(24);

        return Inertia::render('Doctors/Index', compact('doctors'));
    }

}
