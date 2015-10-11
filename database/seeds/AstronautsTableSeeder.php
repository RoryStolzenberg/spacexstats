<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Astronaut;

class AstronautsTableSeeder extends Seeder {
    public function run() {
        Astronaut::create(array(
            'first_name' => 'Robert',
            'last_name' => 'Behnken',
            'gender' => 'Male',
            'deceased' => false,
            'nationality' => 'United States',
            'date_of_birth' => Carbon::createFromDate(1970, 7, 28),
            'contracted_by' => 'NASA'
        ));

        Astronaut::create(array(
            'first_name' => 'Sunita',
            'last_name' => 'Williams',
            'gender' => 'Female',
            'deceased' => false,
            'nationality' => 'United States',
            'date_of_birth' => Carbon::createFromDate(1965, 9, 19),
            'contracted_by' => 'NASA'
        ));

        Astronaut::create(array(
            'first_name' => 'Eric',
            'last_name' => 'Boe',
            'gender' => 'Male',
            'deceased' => false,
            'nationality' => 'United States',
            'date_of_birth' => Carbon::createFromDate(1964, 10, 1),
            'contracted_by' => 'NASA'
        ));

        Astronaut::create(array(
            'first_name' => 'Douglas',
            'last_name' => 'Hurley',
            'gender' => 'Male',
            'deceased' => false,
            'nationality' => 'United States',
            'date_of_birth' => Carbon::createFromDate(1966, 10, 21),
            'contracted_by' => 'NASA'
        ));
    }
}