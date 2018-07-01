<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class DoctorLeave extends Model
{
    protected $table = "doctor_leaves";
    protected $fillable = ['doctor_id', 'from_date', 'to_date'];

}
