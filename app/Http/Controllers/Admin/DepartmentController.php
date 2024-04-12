<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DepartmentController extends Controller
{
    /*function __construct()
    {
        $this->middleware('role_or_permission:Department access|Department create|Department edit|Department delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Department create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Department edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Department delete', ['only' => ['destroy']]);
    }*/


    public function create(){
        $title = "Departments";
        $departments = Department::get();
        return view('backend.departments.new',compact('title','departments'));
    }
    public function index()
    {
        $title = "Departments";
        $departments = Department::get();
        return view('backend.departments.index',compact('title','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required|max:100']);
        Department::create($request->all());
        return back()->with('success',"Added Successfully!!.");
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
    public function update(Request $request)
    {
        /*$this->validate($request,['name'=>'required|max:100']);
        $department = Department::find($request->id);
        $department->update([
            'name'=>$request->name,
        ]);
        return back()->with('success',"Updated Successfully!!.");*/
        
        //data update code with codium
        /*$this->validate($request, ['name' => 'required|max:100']);
        $department = Department::findOrNew($request->id);
        
        if ($department->exists) {
            $department->update([
                'name' => $request->name,
            ]);
            return back()->with('success', "Updated Successfully!!");
        } else {
            // Handle the case where the department is not found
            return back()->with('error', "Department not found or invalid ID");
        }*/

        $this->validate($request, ['name' => 'required|max:100']);
        $department = Department::find($request->id);
    
        if ($department) {
            $department->name = $request->name;
            $department->save();
            return back()->with('success', "Updated Successfully!!");
        } else {
            // Handle the case where the department is not found
            return back()->with('error', "Department not found or invalid ID");
        }

    }

    public function edit($id)
    {
        $department = Department::find($id);
        $departments = Department::all(); 
        return view('backend.departments.edit',['department' => $department, 'departments' => $departments ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //$department = Department::find($request->id);
        $department->delete();
        return redirect()->back()->withSuccess("Department deleted !!!");
        //return back()->with('success',"Deleted Successfully!!.");
    }

}
