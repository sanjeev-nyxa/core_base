<?php

namespace Labs\Core\Entities\Import;


use RGilyov\CsvImporter\BaseCsvImporter;
use Spatie\TranslationLoader\LanguageLine;

/**
 * Class TranslationImporter
 * @package Labs\Core\Entities\Import
 */
class TranslationImporter extends BaseCsvImporter
{
    /**
     *  Specify mappings and rules for the csv importer, you also may create csv files to write csv entities
     *  and overwrite global configurations
     *
     * @return array
     */
    public function csvConfigurations()
    {
        return [
            'mappings' => [
                'Id' => ['validation' => ['string']],
                'Group' => ['validation' => ['string']],
                'Key' => ['validation' => ['string']],
                'Text_en' => ['validation' => ['string']],
                'Text_ar' => ['validation' => ['string']],
            ]
        ];
    }

    /**
     *  Will be executed for a csv line if it passed validation
     *
     * @param $item
     * @return void
     */
    public function handle($item)
    {
        LanguageLine::updateOrCreate(
            ['id' => $item['id']],
            [
                'group' => $item['group'],
                'key' => $item['key'],
                'text' => [
                    'en' => $item['en'],
                    'ar' => $item['ar'],
                ]
            ]
        );
    }

    /**
     *  Will be executed if a csv line did not pass validation
     *
     * @param $item
     * @return void
     */
    public function invalid($item)
    {

    }
}