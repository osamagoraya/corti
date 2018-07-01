<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = "appointments";
    protected $fillable = ['doctor_id', 'patient_id', 'description', 'room', 'start_date', 'type', 'backgroundColor', 'foregroundColor'];

    public $timestamps = true;

    public function doctor()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class);
    }
}
