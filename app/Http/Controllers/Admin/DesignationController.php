<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DesignationController extends Controller
{
    /*function __construct()
    {
        $this->middleware('role_or_permission:Designation access|Designation create|Designation edit|Designation delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Designation create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Designation edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Designation delete', ['only' => ['destroy']]);
    }*/

    public function create(){
        $departments = Department::all();
        return view('backend.designations.new')->with('departments', $departments);
    }

    public function index()
    {
        $title = "Designation";
        $designations = Designation::with('department')->get();
        $designations = Designation::get();
        return view('backend.designations.index',compact('title','designations'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'designation'=>'required|max:200',
            'department'=>'required',
        ]);
        Designation::create([
            'name'=>$request->designation,
            'department_id'=>$request->department,
        ]);
        return back()->with('success','Designation added successfully!!!');
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
     * 
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $this->validate($request,[
            'designation'=>'required|max:200',
            'department'=>'required',
        ]);
        $designation = Designation::findOrFail($request->id);
        $designation->update([
            'name'=>$request->designation,
            'department_id'=>$request->department,
        ]);
        return back()->with('success',"designation has been updated");
    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        $departments = Department::all(); // Assuming you also need to pass departments to the view
        
        return view('backend.designations.edit', ['designation' => $designation, 'departments' => $departments]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $   
     * @return \Illuminate\Http\Response
     */
    public function destroy(Designation $designation) // previous Request $request
    {
        //$designation = Designation::findOrFail($request->id);
        $designation->delete();
        //return back()->with('success',"Designation has been deleted successfully!!");
        return redirect()->back()->withSuccess('Designation deleted !!!');

    }
}
