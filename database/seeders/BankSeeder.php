<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            ['name' => 'Banco Agrario', 'picture' => 'img/banks/banco-agrario.png'],
            ['name' => 'Banco AV Villas', 'picture' => 'img/banks/banco-av-villas.png'],
            ['name' => 'Banco Caja Social', 'picture' => 'img/banks/banco-caja-social.png'],
            ['name' => 'Banco de Bogotá', 'picture' => 'img/banks/banco-de-bogota.png'],
            ['name' => 'Banco de Occidente', 'picture' => 'img/banks/banco-de-occidente.png'],
            ['name' => 'BBVA', 'picture' => 'img/banks/bbva.png'],
            ['name' => 'Coopcentral', 'picture' => 'img/banks/coopcentral.png'],
            ['name' => 'Davivienda', 'picture' => 'img/banks/davivienda.png'],
            ['name' => 'Banco Falabella', 'picture' => 'img/banks/banco-falabella.png'],
            ['name' => 'Banco GNB Sudameris', 'picture' => 'img/banks/banco-gnb-sudameris.png'],
            ['name' => 'Banco Pichincha', 'picture' => 'img/banks/banco-pichincha.png'],
            ['name' => 'Banco Popular', 'picture' => 'img/banks/banco-popular.png'],
            ['name' => 'Banco Santander', 'picture' => 'img/banks/banco-santander.png'],
            ['name' => 'Banco Serfinanza', 'picture' => 'img/banks/banco-serfinanza.png'],
            ['name' => 'Bancolombia', 'picture' => 'img/banks/bancolombia.png'],
            ['name' => 'Bancoomeva', 'picture' => 'img/banks/bancoomeva.png'],
            ['name' => 'Citibank', 'picture' => 'img/banks/citibank.png'],
            ['name' => 'Confiar', 'picture' => 'img/banks/confiar.png'],
            ['name' => 'Daviplata', 'picture' => 'img/banks/daviplata.png'],
            ['name' => 'Movii', 'picture' => 'img/banks/movii.png'],
            ['name' => 'Itau', 'picture' => 'img/banks/itau.png'],
            ['name' => 'Nequi', 'picture' => 'img/banks/nequi.png'],
            ['name' => 'Scotiabank Colpatria', 'picture' => 'img/banks/scotiabank-colpatria.png'],
            ['name' => 'Bancamia', 'picture' => 'img/banks/bancamia.png'],
            ['name' => 'Rappipay', 'picture' => 'img/banks/rappipay.png'],
            ['name' => 'Dale', 'picture' => 'img/banks/dale.png'],
            ['name' => 'Iris Bank', 'picture' => 'img/banks/iris-bank.png'],
            ['name' => 'Coofinep', 'picture' => 'img/banks/coofinep.png'],
            ['name' => 'Banco Unión', 'picture' => 'img/banks/banco-union.png'],
            ['name' => 'Lulo Bank', 'picture' => 'img/banks/lulo-bank.png'],
        ]);
    }
}
