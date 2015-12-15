<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Payload;

class PayloadsTableSeeder extends Seeder {
    public function run() {
        Payload::create([
            'mission_id' => 1,
            'name' => 'FalconSAT-2',
            'operator' => "U.S. Air Force",
            'primary' => true,
            'mass' => 19.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/falconsat-2.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'Trailblazer',
            'operator' => "U.S. Air Force",
            'primary' => false,
            'mass' => 83.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/trailblazer.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'PRESat',
            'operator' => "NASA Ames Research Center",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/presat.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'NanoSail-D',
            'operator' => "NASA Ames Research Center",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/nanosail-d.htm'
        ]);

        Payload::create([
            'mission_id' => 3,
            'name' => 'Celestis 7',
            'operator' => "Celestis",
            'primary' => false,
            'link' => 'http://space.skyrocket.de/doc_sdat/celestis-07.htm'
        ]);

        Payload::create([
            'mission_id' => 5,
            'name' => 'RazakSAT',
            'operator' => "Astronautic Technology, Malaysia",
            'primary' => true,
            'mass' => 200,
            'link' => 'http://space.skyrocket.de/doc_sdat/razaksat.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'SMDC-ONE 1',
            'operator' => "U.S. Army SMDC",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/smdc-one.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'QbX 1',
            'operator' => "NRL Naval Center for Space for NRO",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/qbx-1.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'QbX 2',
            'operator' => "NRL Naval Center for Space for NRO",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/qbx-1.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Mayflower-Caerus',
            'operator' => "Northrop Grumman, University of Southern California",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/mayflower-caerus.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 000',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 001',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 002',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 7,
            'name' => 'Perseus 003',
            'operator' => "Los Alamos National Laboratory",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/perseus-000.htm'
        ]);

        Payload::create([
            'mission_id' => 8,
            'name' => 'Celestis 11',
            'operator' => "Celestis",
            'primary' => false,
            'link' => 'http://space.skyrocket.de/doc_sdat/celestis-11.htm'
        ]);

        Payload::create([
            'mission_id' => 9,
            'name' => 'Orbcomm OG2 1 (H1)',
            'operator' => "Orbcomm",
            'primary' => false,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
        Payload::create([
            'mission_id' => 11,
            'name' => 'CASSIOPE',
            'operator' => "MacDonald Dettwiler (MDA), Canada",
            'primary' => true,
            'mass' => 500,
            'link' => 'http://space.skyrocket.de/doc_sdat/cassiope-1.htm'
        ]);
        Payload::create([
            'mission_id' => 11,
            'name' => 'CUSat',
            'operator' => "Cornell University",
            'primary' => false,
            'mass' => 25,
            'link' => 'http://space.skyrocket.de/doc_sdat/cusat.htm'
        ]);
        Payload::create([
            'mission_id' => 11,
            'name' => 'DANDE',
            'operator' => "University of Colorado at Boulder",
            'primary' => false,
            'mass' => 50,
            'link' => 'http://space.skyrocket.de/doc_sdat/dande.htm'
        ]);
        Payload::create([
            'mission_id' => 11,
            'name' => 'POPACS 1',
            'operator' => "Utah State University, Gil Moore, Drexel University, others",
            'primary' => false,
            'mass' => 1,
            'link' => 'http://space.skyrocket.de/doc_sdat/popacs.htm'
        ]);
        Payload::create([
            'mission_id' => 11,
            'name' => 'POPACS 2',
            'operator' => "Utah State University, Gil Moore, Drexel University, others",
            'primary' => false,
            'mass' => 1.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/popacs.htm'
        ]);
        Payload::create([
            'mission_id' => 11,
            'name' => 'POPACS 3',
            'operator' => "Utah State University, Gil Moore, Drexel University, others",
            'primary' => false,
            'mass' => 2,
            'link' => 'http://space.skyrocket.de/doc_sdat/popacs.htm'
        ]);
        Payload::create([
            'mission_id' => 12,
            'name' => 'SES-8',
            'operator' => "SES World Skies",
            'primary' => true,
            'mass' => 3138,
            'link' => 'http://space.skyrocket.de/doc_sdat/ses-8.htm'
        ]);
        Payload::create([
            'mission_id' => 13,
            'name' => 'Thaicom 6',
            'operator' => "Thaicom",
            'primary' => true,
            'mass' => 3016,
            'link' => 'http://space.skyrocket.de/doc_sdat/thaicom-6.htm'
        ]);
        Payload::create([
            'mission_id' => 14,
            'name' => 'ALL-STAR/THEIA',
            'operator' => "Colorado Space Grant Consortium",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/all-star-theia.htm'
        ]);
        Payload::create([
            'mission_id' => 14,
            'name' => 'KickSat 1',
            'operator' => "Cornell University",
            'primary' => false,
            'mass' => 5.5,
            'link' => 'http://space.skyrocket.de/doc_sdat/kicksat-1.htm'
        ]);
        Payload::create([
            'mission_id' => 14,
            'name' => 'SporeSat',
            'operator' => "NASA Ames Research Center, Purdue University",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/sporesat.htm'
        ]);
        Payload::create([
            'mission_id' => 14,
            'name' => 'TSAT (TestSat-Lite)',
            'operator' => "Taylor University",
            'primary' => false,
            'mass' => 2,
            'link' => 'http://space.skyrocket.de/doc_sdat/tsat.htm'
        ]);
        Payload::create([
            'mission_id' => 15,
            'name' => 'Orbcomm OG2 3',
            'operator' => "Orbcomm",
            'primary' => true,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
        Payload::create([
            'mission_id' => 15,
            'name' => 'Orbcomm OG2 4',
            'operator' => "Orbcomm",
            'primary' => true,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
        Payload::create([
            'mission_id' => 15,
            'name' => 'Orbcomm OG2 6',
            'operator' => "Orbcomm",
            'primary' => true,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
        Payload::create([
            'mission_id' => 15,
            'name' => 'Orbcomm OG2 7',
            'operator' => "Orbcomm",
            'primary' => true,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
        Payload::create([
            'mission_id' => 15,
            'name' => 'Orbcomm OG2 9',
            'operator' => "Orbcomm",
            'primary' => true,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
        Payload::create([
            'mission_id' => 15,
            'name' => 'Orbcomm OG2 11',
            'operator' => "Orbcomm",
            'primary' => true,
            'mass' => 172,
            'link' => 'http://space.skyrocket.de/doc_sdat/orbcomm-2.htm'
        ]);
        Payload::create([
            'mission_id' => 16,
            'name' => 'AsiaSat 8',
            'operator' => "Asia Satellite Telecommunications Company",
            'primary' => true,
            'mass' => 4535,
            'link' => 'http://space.skyrocket.de/doc_sdat/asiasat-8.htm'
        ]);
        Payload::create([
            'mission_id' => 17,
            'name' => 'AsiaSat 6',
            'operator' => "Asia Satellite Telecommunications Company",
            'primary' => true,
            'mass' => 4428,
            'link' => 'http://space.skyrocket.de/doc_sdat/asiasat-6.htm'
        ]);
        Payload::create([
            'mission_id' => 18,
            'name' => 'SpinSat',
            'operator' => "Naval Research Laboratory (NRL)",
            'primary' => false,
            'mass' => 57,
            'link' => 'http://space.skyrocket.de/doc_sdat/spinsat.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 19,
            'name' => "Flock-1d' 1 (Dove 0A16)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 19,
            'name' => "Flock-1d' 2 (Dove 0C02)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 19,
            'name' => "AESP-14",
            'operator' => "ITA, INPE",
            'primary' => false,
            'mass' => 1,
            'link' => 'http://space.skyrocket.de/doc_sdat/aesp-14.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 20,
            'name' => "DSCOVR",
            'operator' => "NOAA",
            'primary' => true,
            'mass' => 570,
            'link' => 'http://space.skyrocket.de/doc_sdat/dscovr.htm'
        ]);
        Payload::create([
            'mission_id' => 21,
            'name' => "ABS 3A",
            'operator' => "Asia Broadcast Satellite",
            'primary' => true,
            'mass' => 1954,
            'link' => 'http://space.skyrocket.de/doc_sdat/abs-3a.htm'
        ]);
        Payload::create([
            'mission_id' => 21,
            'name' => "Eutelsat 115 West B",
            'operator' => "Eutelsat",
            'primary' => true,
            'mass' => 2205,
            'link' => 'http://space.skyrocket.de/doc_sdat/eutelsat-115-west-b.htm'
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 1 (Dove 0B1A)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 2 (Dove 0B10)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 3 (Dove 0C03)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 4 (Dove 0C06)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 5 (Dove 0B07)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 6 (Dove 0B0B)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 7 (Dove 0B0E)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 8 (Dove 0B0D)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 9 (Dove 0B1F)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 10 (Dove 0B09)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 11 (Dove 0B1E)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 12 (Dove 0B0A)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 13 (Dove 0C07)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Flock-1e 14 (Dove 0B0F)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Arkyd-3 Reflight",
            'operator' => "Planetary Resources",
            'primary' => false,
            'mass' => 4,
            'link' => 'http://space.skyrocket.de/doc_sdat/arkyd-3.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 22,
            'name' => "Centennial 1",
            'operator' => "Booz Allen Hamilton, Air Force Research Laboratory",
            'primary' => false,
            'mass' => 1,
            'link' => 'http://space.skyrocket.de/doc_sdat/centennial-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 23,
            'name' => utf8_encode("TürkmenÄlem 52E"),
            'operator' => "Turkmen Ministry of Communications",
            'primary' => true,
            'mass' => 4707,
            'link' => 'http://space.skyrocket.de/doc_sdat/turkmenalem-52e.htm'
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 1 (Dove 0B25)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 2 (Dove 0B31)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 3 (Dove 0B26)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 4 (Dove 0B33)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 5 (Dove 0B28)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 6 (Dove 0B2E)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 7 (Dove 0B2D)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
        Payload::create([
            'mission_id' => 24,
            'name' => "Flock-1f 8 (Dove 0B32)",
            'operator' => "Planet Labs",
            'primary' => false,
            'mass' => 5,
            'link' => 'http://space.skyrocket.de/doc_sdat/flock-1.htm',
            'as_cargo' => true
        ]);
    }
}