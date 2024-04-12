<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ImportExcel;
use App\Http\Controllers\Controller;
use App\User;
use Session;
use Hash;
use Image;
use Carbon\Carbon;

class ImportExcelController extends Controller
{
    function index()
    {
        $data = DB::table('import_excels')->orderBy('id', 'DESC')->get();
        $user = Auth::user();
        return view('setting.ImportExcel.index', compact('data','user'));
        
    }

    function import(Request $request)
    {

        $this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx'
        ],

        [
            'select_file.required' => __('.'),
        ]);

        $file = $request->select_file;
        Excel::import(new ExcelImport ,$file);

        return redirect()->back()->with('success', 'Import successful.!');

    }

    // insert
    public function importInsert(Request $request)
    {
		$request->validate([
                            'No'   => 'required',
                            'First_Name' => 'required',
                            'Last_Name'  => 'required',
                            'Email'  => 'required|email|unique:users', //added unique Users & Email
                            'Contact_Number'   => 'required|max:10',
                            'Alternate_Number' => 'required|max:10',
                            'Designations'  => 'required',
                            'Work_Status' => 'required',
                            'Years_of_Experience'  => 'required|numeric',
                            //'Action' => 'required'
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
                    'No' 			        =>	    $request->No,
                    'First_Name' 		    =>	    $request->First_Name,
                    'Last_Name' 		    =>	    $request->Last_Name,
                    'Email' 			    =>	    $request->Email,
		            'Contact_Number' 		=>	    $request->Contact_Number,
                    'Alternate_Number' 		=>	    $request->Alternate_Number,
                    'Designations' 		    =>	    $request->Designations,
                    'Work_Status' 		    =>	    $request->Work_Status,
                    'Years_of_Experience' 	=>	    $request->Years_of_Experience
                ];
                //DB::table('import_excels')->insert($importInsert);
                ImportExcel::create($importInsert);
                return redirect()->back()->with('importInsert','Insert Sucessful.!');
            }

        }
    }
    // update
	public function importUpdate(Request $request)
	{
		$importUpdate = [
            'id'			        =>	    $request->idUpdate,
		    'No' 			        =>	    $request->No,
            'First_Name' 		    =>	    $request->First_Name,
            'Last_Name' 		    =>	    $request->Last_Name,
            'Email' 			    =>	    $request->Email,
		    'Contact_Number' 		=>	    $request->Contact_Number,
            'Alternate_Number' 		=>	    $request->Alternate_Number,
            'Designations' 		    =>	    $request->Designations,
            'Work_Status' 		    =>	    $request->WorkStatus,
            'Years_of_Experience' 	=>	    $request->Years_of_Experience
        ];
		DB::table('import_excels')->where('id',$request->idUpdate)->update($importUpdate);
		return redirect()->back()->with('importUpdate' ,'Update Successfull.!');
    }

    // delete
    public function importDelete($importID)
    {
		DB::table('import_excels')->where('id',$importID)->delete();
		return redirect()->back()->with('importDelete','Delect Successfull.!');
	}

}
