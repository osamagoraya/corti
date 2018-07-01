<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user         =  auth()->user();
        $query        = Appointment::query();

        $currentMonth = Carbon::now();
        $monthStart   =  $currentMonth->startOfMonth()->format('Y-m-d');
        $monthEnd     =  $currentMonth->endOfMonth()->format('Y-m-d');
        $roles        = $user->getRoleNames(); // Returns a collection

        if($roles->contains('doctor')){

            $query->where('doctor_id', $user->id);

        }else if($roles->contains('user')){

            $query->where('patient_id', $user->id());

        }

        $appointments = $query->whereBetween('start_date', array($monthStart, $monthEnd))->get();
        $appointments->load('patient', 'doctor');
        return view('backend.dashboard', compact('appointments', 'user'));
    }
}
