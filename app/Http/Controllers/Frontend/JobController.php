<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\JobApplicant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class JobController extends Controller
{

    //code for Job permission not required for fornted/job/view
    
    public function index(){

        //Job indexing code start
        $title = "Jobs";
        $jobs = DB::table('jobs')->get();
        $jobs = Job::with('department')->get();
        return view('components.job.joblist', compact('title', 'jobs'));
    }

    
    //Code for Job View 
    /*public function show(Job $job){
        $title = "Job View";
        return view('components.job.joblist',compact(
            'title','jobs'
        ));

        //return view('components.job.joblist', ['jobs' => $jobs]);

    } */

    public function show(Job $job){
        $title = "Job View";
        
        // Assuming you retrieve $jobs from somewhere, such as querying from the database
        $jobs = Job::all(); // Example, replace this with your actual query
    
        return view('components.job.jobview', compact('title', 'jobs'));
    }

    public function apply(Request $request, $id)
    {
        $title = "Apply";
        $job = Job::find($id);
        return view('components.job.apply', compact('title', 'job'));
        
        
        // Your code to handle job application goes here
    }

}
