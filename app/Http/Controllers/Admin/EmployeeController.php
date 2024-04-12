<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
    /*function __construct()
    {
        $this->middleware('role_or_permission:Employee access|Employee create|Employee edit|Employee delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Employee create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Employee edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Employee delete', ['only' => ['destroy']]);
    }*/

    public function index()
    {
        $title="employees";
        $designations = Designation::get();
        $departments = Department::get();
        $employees = Employee::with('department','designation')->get();
        return view('backend.employees.index',
        compact('title','designations','departments','employees'));
    }

    public function create()
    {
        $title="employees";
        $designations = Designation::get();
        $departments = Department::get();
        $employees = Employee::with('department','designation')->get();
        return view('backend.employees.new',
        compact('title','designations','departments','employees'));
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function list()
   {
       $title="employees";
       $designations = Designation::get();
       $departments = Department::get();
       $employees = Employee::with('department','designation')->get();
       return view('backend.employees-list',
       compact('title','designations','departments','employees'));
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'cheque_no' => 'required|numer',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'contactnumber' => 'nullable|max:15',
            'alternatenumber' => 'nullable|max:15',
            'company' => 'required|max:200',
            'department' => 'required|exists:departments,id',
            'designation' => 'required|exists:designations,id',
            'work_status' => 'required|in:experienced,fresher',
            'years_of_experience' => 'required|numeric',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
        ]);
        $imageName = Null;
        if ($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        }
        $uuid = IdGenerator::generate(['table' => 'employees','field'=>'uuid', 'length' => 7, 'prefix' =>'EMP-']);
        Employee::create([
            'uuid' => $uuid,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'contactnumber' => $request->contactnumber,
            'alternatenumber' => $request->alternatenumber,
            'company' => $request->company,
            'department_id' => $request->department,
            'designation_id' => $request->designation,
            'work_status' => $request->work_status,
            'years_of_experience' => $request->years_of_experience,
            'avatar' => $imageName,
        ]);
        return back()->with('success',"Employee has been added");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id){
        $title="employees";
        $designations = Designation::get();
        $departments = Department::get();
        $employees = Employee::with('department','designation')->get();
        $employee = Employee::find($id);
        return view('backend.employees.edit',
        compact('title','designations','departments','employees','employee'));
    }
    public function update(Request $request)
    {
        $this->validate($request,[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'contactnumber' => 'nullable|max:15',
            'alternatenumber' => 'nullable|max:15',
            'company' => 'required|max:200',
            'department' => 'required|exists:departments,id',
            'designation' => 'required|exists:designations,id',
            'work_status' => 'required|in:experienced,fresher',
            'years_of_experience' => 'required|numeric',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
        ]);
        if ($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        }else{
            $imageName = Null;
        }
        
        $employee = Employee::find($request->id);
        if($employee){
            $employee->update([
                'uuid' => $employee->uuid,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'contactnumber' => $request->contactnumber,
                'alternatenumber' => $request->alternatenumber,
                'company' => $request->company,
                'department_id' => $request->department,
                'designation_id' => $request->designation,
                'work_status' => $request->work_status,
                'years_of_experience' => $request->years_of_experience,
                'avatar' => $imageName,
            ]);
            return back()->with('success',"Employee details has been updated");
        } else{
            // Handle the case where the employee is not found
            return back()->with('error', "Employee not found or invalid ID");
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function destroy(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->delete();
        return back()->with('success',"Employee has been deleted");
    }*/

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success','Employee deleted successfully');
}
}