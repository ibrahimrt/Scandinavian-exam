<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TranslateExports implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(
        array $translations
    ) {        
        $this->translations = $translations;
    }
    public function headings(): array
    {
        return [
            'Name',
            'English',
            'Español',
            'Deutshc',
            'Français',
            'Dansk',
        ];
    }
    public function collection()
    {
        $translations = collect($this->translations);
        return $translations;

    }
    
}
