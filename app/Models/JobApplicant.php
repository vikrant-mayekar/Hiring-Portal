<?php

namespace App\Models;

use App\Models\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplicant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'alternate_number',
        'full_address',
        'location',
        'pincode',
        'interview_for',
        'current_designation',
        'being_interviewed_for',
        'work_status',
        'total_experience',
        'cv',
        'message',
        'job_id',
    ];

    public function Job(){
        return $this->belongsTo(Job::class);
    }
   
}
