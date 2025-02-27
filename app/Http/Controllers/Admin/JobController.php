<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\Department;
use App\Models\Designation;
use App\Models\JobApplicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class JobController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Job access|Job create|Job edit|Job delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Job create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Job edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Job delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(){
        $title = "Add Job";
        $departments = Department::get();
        $designations = Designation::get();
        $jobs = Job::with('department')->get();
        return view('backend.jobs.new',compact(
            'title','departments','designations'
        ));
    }

    public function index()
    {
        $title = "jobs";
        $jobs = Job::with('department')->get();
        $departments = Department::get();
        return view('backend.jobs.index',compact(
            'title','departments','jobs'
        ));
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
            'title'=>'required',
            'department'=>'required',
            'designation'=>'required',
            //'location'=>'required',
            'vacancies'=>'required',
            'experience'=>'required',
            'age'=>'nullable',
            'salary_from'=>'nullable',
            'salary_to'=>'nullable',
            'type'=>'required',
            'status'=>'required',
            'start_date'=>'required',
            'expire_date'=>'required',
            'description'=>'required',
        ]);
        Job::create($request->all());
        return back()->with('success',"Job has been added Posted!!");
    }

    public function applicants(){
        $title = 'Job Applicants';
        $applicants = JobApplicant::with('Job')->latest()->get();
        return view('backend.job-applicants.index',compact(
            'title','applicants'
        ));
    }


    /*Code edit for job-applicant code start*/
    public function applicantsedit(){
        $title = 'Job Applicants';
        $applicants = JobApplicant::with('Job')->latest()->get();
        return view('backend.job-applicants.index',compact(
            'title','applicants'
        ));
    }
    /*Code End*/

    public function downloadCv(Request $request){
        $pathToFile = public_path('storage/cv/'. $request->cv);
        return response()->download($pathToFile)->with('success',"Applicant cv has been downloaded");
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
    
    public function edit($id){
        $title = "Edit Job";
        $job = Job::findOrFail($id);
        $departments = Department::get();
        $designations = Designation::get();
        return view('backend.jobs.edit',compact(
            'title','job','departments','designations'
        ));
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
        $request->validate([
            'title'=>'required',
            'department'=>'required',
            'location'=>'required',
            'vacancies'=>'required',
            'experience'=>'required',
            'age'=>'nullable',
            'salary_from'=>'nullable',
            'salary_to'=>'nullable',
            'type'=>'required',
            'status'=>'required',
            'start_date'=>'required',
            'expire_date'=>'required',
            'description'=>'required',
        ]);
        $job = Job::findOrFail($request->id);
        $job->update([
            'title' => $request->title ?? $job->title,
            'department_id' => $request->department ?? $job->department_id,
            'location' => $request->location ?? $job->location,
            'vacancies' => $request->vacancies ?? $job->vacancies,
            'experience' => $request->experience ?? $job->experience,
            'age' => $request->age ?? $job->age,
            'salary_from' => $request->salary_from ?? $job->salary_from,
            'salary_to' => $request->salary_to ?? $job->salary_to,
            'type' => $request->type ?? $job->type,
            'status' => $request->status ?? $job->status,
            'start_date' => $request->start_date ?? $job->start_date,
            'expire_date' => $request->expire_date ?? $job->expire_date,
            'description' => $request->description ?? $job->description,
        ]);
        return back()->with('success',"Job has been updated successfully!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Job::findOrFail($request->id)->delete();
        return back()->with('success',"Job has been deleted successfully!!");
    }



}
