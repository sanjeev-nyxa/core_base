<?php

namespace Labs\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Labs\Core\Entities\Import\TranslationImporter;

class TranslationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $importer = (new TranslationImporter())->setCsvFile(__DIR__ . '/Data/translations.csv');
        $importer->run();

        $importer->finish();
    }
}
