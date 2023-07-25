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
            [
                'slug' => 'banco-agrario',
                'name' => 'Banco Agrario',
                'picture' => 'img/banks/banco-agrario.png',
            ],
            [
                'slug' => 'banco-av-villas',
                'name' => 'Banco AV Villas',
                'picture' => 'img/banks/banco-av-villas.png',
            ],
            [
                'slug' => 'banco-caja-social',
                'name' => 'Banco Caja Social',
                'picture' => 'img/banks/banco-caja-social.png',
            ],
            [
                'slug' => 'banco-de-bogota',
                'name' => 'Banco de Bogotá',
                'picture' => 'img/banks/banco-de-bogota.png',
            ],
            [
                'slug' => 'banco-de-occidente',
                'name' => 'Banco de Occidente',
                'picture' => 'img/banks/banco-de-occidente.png',
            ],
            [
                'slug' => 'bbva',
                'name' => 'BBVA',
                'picture' => 'img/banks/bbva.png',
            ],
            [
                'slug' => 'coopcentral',
                'name' => 'Coopcentral',
                'picture' => 'img/banks/coopcentral.png',
            ],
            [
                'slug' => 'davivienda',
                'name' => 'Davivienda',
                'picture' => 'img/banks/davivienda.png',
            ],
            [
                'slug' => 'banco-falabella',
                'name' => 'Banco Falabella',
                'picture' => 'img/banks/banco-falabella.png',
            ],
            [
                'slug' => 'banco-gnb-sudameris',
                'name' => 'Banco GNB Sudameris',
                'picture' => 'img/banks/banco-gnb-sudameris.png',
            ],
            [
                'slug' => 'banco-pichincha',
                'name' => 'Banco Pichincha',
                'picture' => 'img/banks/banco-pichincha.png',
            ],
            [
                'slug' => 'banco-popular',
                'name' => 'Banco Popular',
                'picture' => 'img/banks/banco-popular.png',
            ],
            [
                'slug' => 'banco-santander',
                'name' => 'Banco Santander',
                'picture' => 'img/banks/banco-santander.png',
            ],
            [
                'slug' => 'banco-serfinanza',
                'name' => 'Banco Serfinanza',
                'picture' => 'img/banks/banco-serfinanza.png',
            ],
            [
                'slug' => 'bancolombia',
                'name' => 'Bancolombia',
                'picture' => 'img/banks/bancolombia.png',
            ],
            [
                'slug' => 'bancoomeva',
                'name' => 'Bancoomeva',
                'picture' => 'img/banks/bancoomeva.png',
            ],
            [
                'slug' => 'citibank',
                'name' => 'Citibank',
                'picture' => 'img/banks/citibank.png',
            ],
            [
                'slug' => 'confiar',
                'name' => 'Confiar',
                'picture' => 'img/banks/confiar.png',
            ],
            [
                'slug' => 'daviplata',
                'name' => 'Daviplata',
                'picture' => 'img/banks/daviplata.png',
            ],
            [
                'slug' => 'movii',
                'name' => 'Movii',
                'picture' => 'img/banks/movii.png',
            ],
            [
                'slug' => 'itau',
                'name' => 'Itau',
                'picture' => 'img/banks/itau.png',
            ],
            [
                'slug' => 'nequi',
                'name' => 'Nequi',
                'picture' => 'img/banks/nequi.png',
            ],
            [
                'slug' => 'scotiabank-colpatria',
                'name' => 'Scotiabank Colpatria',
                'picture' => 'img/banks/scotiabank-colpatria.png',
            ],
            [
                'slug' => 'bancamia',
                'name' => 'Bancamia',
                'picture' => 'img/banks/bancamia.png',
            ],
            [
                'slug' => 'rappipay',
                'name' => 'Rappipay',
                'picture' => 'img/banks/rappipay.png',
            ],
            [
                'slug' => 'dale',
                'name' => 'Dale',
                'picture' => 'img/banks/dale.png',
            ],
            [
                'slug' => 'iris-bank',
                'name' => 'Iris Bank',
                'picture' => 'img/banks/iris-bank.png',
            ],
            [
                'slug' => 'coofinep',
                'name' => 'Coofinep',
                'picture' => 'img/banks/coofinep.png',
            ],
            [
                'slug' => 'banco-union',
                'name' => 'Banco Unión',
                'picture' => 'img/banks/banco-union.png',
            ],
            [
                'slug' => 'lulo-bank',
                'name' => 'Lulo Bank',
                'picture' => 'img/banks/lulo-bank.png',
            ],
        ]);
    }
}
