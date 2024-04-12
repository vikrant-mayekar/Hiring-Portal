<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ImportExcel extends Model
{
    use HasFactory;

    protected $fillable = ['No', 'First_Name', 'Last_Name', 'Email', 'Contact_Number', 'Alternate_Number', 'Designations', 'Work_Status', 'Years_of_Experience'];
    public function importInsert(Request $request)
    {
        $request->validate([
            'No'   => 'required',
            'First_Name' => 'required',
            'Last_Name' => 'required',
            'Email' => 'required',
            'Contact_Number' => 'required',
            'Alternate_Number' => 'required',
            'Designation' => 'required',
            'Work_Status' => 'required',
            'Years_of_Experience' => 'required'
        ]);

        if($request->get('No'))
        {
            $codesExists = $request->get('No');
            $data = DB::table("import_excels")->where('id', $codesExists)->count();
            if($data > 0)
            {
                return redirect()->back()->with('codesExists',"Exit already.!");
            }
            else
            {
                $importInsert = [
                    'No' 	=>	$request->No,
                    'First_Name' 	=>	$request->First_Name,
                    'Last_Name' 	=>	$request->Last_Name,
                    'Email' 	=>	$request->Email,
                    'Contact_Number' 	=>	$request->Contact_Number,
                    'Alternate_Number' 	=>	$request->Alternate_Number,
                    'Designations' 	=>	$request->Designations,
                    'Work_Status' 	=>	$request->Work_Status,
                    'Years_of_Experience' 	=>	$request->Years_of_Experience
                ];
                ImportExcel::create($importInsert);
                return redirect()->back()->with('importInsert','Insert Sucessful.!');
            }
        }
    }
}
