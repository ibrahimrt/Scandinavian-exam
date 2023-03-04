<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TranslateExports;
use Illuminate\Http\Request;


class DataExportController extends Controller 
{
    public function dataExport( request $request){        
        
        $data = $this->normalizeArray($request->data);
        $translations = $data ? $data : array([]);
        return Excel::download(new TranslateExports($translations), 'DataTranslations.xlsx');
        
    }

    public function normalizeArray($data){
        $translations = [];
        foreach ($data as $item) {
            $textArray = $item['text'];
            $values = [];
        
            foreach (['es', 'en'] as $lang) {
                if($lang== 'es'){
                    $values['Español'] =  $textArray['es'];

                }
                if($lang== 'en'){
                    $values['English'] =  $textArray['en'];
                    
                }      
            }
        
            $translations[] = [
                "Name" => $item["full_key"],
                "Español" =>  $values['Español'],
                "English" =>  $values['English'],
                "Français" =>  $values['English'],
                "Dansk" =>  $values['English'],
                "Deutshc" =>  $values['English'],
            ];
        }
        return $translations;
    }
}
