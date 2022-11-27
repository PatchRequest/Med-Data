<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorsSeeder extends Seeder {

    public function run() {
        User::factory(250, [
            'is_doctor' => true,
            'specialization' => collect(['Cardiologist', 'Dentist', 'Dermatologist', 'Endocrinologist', 'Gastroenterologist', 'Gynecologist', 'Neurologist', 'Ophthalmologist', 'Orthopedist', 'Pediatrician', 'Psychiatrist', 'Surgeon', 'Urologist'])->shuffle()->first(),
        ])->create();
    }

}
