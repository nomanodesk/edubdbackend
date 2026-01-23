<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class StudentsTemplateExport implements FromArray
{
    public function array(): array
    {
        return [
            ['studentname', 'address', 'contactno', 'rollno'],
            ['Noman', 'Uttara, Dhaka', '01999999999','1'],
            ['Munni', 'Modhubag', '01999999998','2'],
        ];
    }
}

