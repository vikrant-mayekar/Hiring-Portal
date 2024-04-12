<?php

namespace App\Http\Controllers\Frontend;

use App\Models\JobApplicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Job;

class JobApplicationController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:JobApplication access|JobApplication edit', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:JobApplication edit', ['only' => ['edit','update']]);
    }
    public function store(Request $request){
        $this->validate($request, [
            'first_name' => 'required|max:200',
            'last_name' => 'required|max:200',
            'email' => 'required|email',
            'mobile_number' => 'required|numeric',
            'alternate_number' => 'nullable|numeric',
            //'full_address' => 'required',
            //'location' => 'required',
            'pincode' => 'required|numeric',
            //'interview_for' => 'required',
            //'current_designation' => 'required',
            //'being_interviewed_for' => 'required',
            'work_status' => 'required|in:experience,fresher',
            //'total_experience' => 'required|numeric',
            //'cv' => 'required|file|mimes:pdf',
        ]);

        $cv = null; // Initialize $cv to null

        if($request->hasFile('cv')){
            $cv = time().'.'.$request->cv->extension();
            $request->cv->move(public_path('storage/cv'), $cv);
        }
        JobApplicant::create([
            'first_name' => $request->first_name, // Add this line
            'last_name' => $request->last_name,   // Add this line
            'email' => $request->email,
            'message' => $request->message,
            'cv' => $cv, //
            'mobile_number' => $request->mobile_number,
            'alternate_number' => $request->alternate_number,
            'full_address' => $request->full_address,
            'location' => $request->location,
            'pincode' => $request->pincode,
            'interview_for' => $request->interview_for,
            'current_designation' => $request->current_designation,
            'being_interviewed_for' => $request->being_interviewed_for,
            'work_status' => $request->work_status,
            'total_experience' => $request->total_experience,
        ]);
        return back()->with('success',"Your application has been sent!!");
    }
}