<?php

namespace Labs\Core\Entities\Export;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Class TranslationsExporter
 * @package Labs\Core\Entities\Export
 */
class TranslationsExporter implements WithHeadings, WithMapping, FromCollection
{

    /**
     * @var Collection
     */
    private $data;

    /**
     * TranslationsExporter constructor.
     * @param Collection $data
     */
    public function __construct(Collection $data)
    {
        $this->data = $data;
    }


    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            'Group',
            'Key',
            'en',
            'ar',
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->group,
            $row->key,
            array_key_exists('en', $row->text) ? $row->text['en'] : '',
            array_key_exists('ar', $row->text) ? $row->text['ar'] : '',
        ];
    }
}