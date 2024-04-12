<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    use HasFactory;
    
    protected $casts = [
        'years_of_experience' => 'decimal:2', // assuming 2 decimal places
    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'contactnumber',
        'alternatenumber',
        'department_id',
        'designation_id',
        'work_status',
        'years_of_experience',
        'company',
    ];
}
