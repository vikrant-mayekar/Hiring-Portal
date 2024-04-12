<?php

namespace App\Imports;

use App\Imports\Log;
use App\Models\ImportExcel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

//class ExcelImport implements ToModel, WithHeadingRow
class ExcelImport implements ToModel      ///////// correct code don't change 
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    

    ////////////////  the code is correct don't change the code  ///////////////////
    public function model(array $row)
    {
        if (count($row) >= 9) {
            return new ImportExcel([
                'No'                    => $row['0'],
                'First_Name'            => $row['1'],
                'Last_Name'             => $row['2'],
                'Email'                 => $row['3'],
                'Contact_Number'        => $row['4'],
                'Alternate_Number'      => $row['5'],
                'Designations'          => $row['6'],
                'Work_Status'           => $row['7'],
                'Years_of_Experience'   => $row['8'],
            ]);
        }
    }

///////////////////// the code is tested don't change ///////////////////////////




}
