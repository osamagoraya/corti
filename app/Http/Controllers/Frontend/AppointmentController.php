<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Auth\Auth;
use App\Models\Appointment;
use App\Models\Auth\User;
use App\Repositories\Frontend\AppointmentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }
    public function index()
    {
        $doctors = User::role('doctor')->get();
        return view('frontend.calender', compact('doctors'));

    }

    public function store(Request $request)
    {
        $data               = $request->except('_token');
        $data['patient_id'] = \Auth::id();
        $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d H:i:s.u0');

        $appointment = Appointment::where('doctor_id', $data['doctor_id'])->where('start_date', $data['start_date'])->first();
        if($appointment){
            return response('error', 404)
                ->header('Content-Type', 'text/plain');
        }
        $this->appointmentRepository->create($data);

    }
    public function getAppointments()
    {

        $query = Appointment::query();

        $currentMonth = Carbon::now();
        $monthStart   =  $currentMonth->startOfMonth()->format('Y-m-d');
        $monthEnd     =  $currentMonth->endOfMonth()->format('Y-m-d');
        $user         =  auth()->user();
        $roles        = $user->getRoleNames(); // Returns a collection

        if($roles->contains('doctor')){

            $query->where('doctor_id', $user->id);
        }else if($roles->contains('user')){

            $query->where('patient_id', $user->id());

        }

        $appointments = $query->whereBetween('start_date', array($monthStart, $monthEnd))->get()->toArray();

        return $appointments;
    }
    public function deleteAppointments($id)
    {
        $appointment = $this->appointmentRepository->findId($id);
        if($appointment){

            $appointment->delete();
            return response()->json([
                'response' => 'success'
            ],200);
        }
        return response()->json([
            'response' => 'error'
        ], 500);
    }
}
