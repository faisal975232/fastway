<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ContactExport implements FromCollection
{

    public function  __construct($start,$limit)
    {
        
        $this->start= $start;
        $this->limit= $limit;
    }


    public function collection()
    {
        return Contact::skip($this->start)->take($this->limit)->get();
    }
}