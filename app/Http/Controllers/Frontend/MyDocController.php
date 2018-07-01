<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Appointment;
use App\Models\DoctorLeave;
use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\PatientCreateDocRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class MyDocController.
 */
class MyDocController extends Controller
{
    /**
     * @param $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke($locale)
    {
        if (array_key_exists($locale, config('locale.languages'))) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }

    public function createPatientByDoc(PatientCreateDocRequest $request){
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email = $request->email;
        $user->type = 'patient';

        $user->save();
        return redirect()->back()->withFlashSuccess('Patient Created Successfully');
    }

    public function createAppointment(){
        $users = User::where('type','patient')->pluck('email','id');
        return view('frontend.add_appointment_doctor')->with('users',$users);
    }

    public function getUserDetails(Request $request){
        $user = User::where('id',$request->user_id)->first();
        return response()->json($user);
    }

    public function addAppointment(Request $request){
        $patient = User::find($request->get('user_id'));
        $doctor_id = auth()->user()->id;

        $appointment = Appointment::where('doctor_id',$doctor_id)
            ->where('appointment_slot',$request->get('appointment_slot'))
            ->where('appointment_date',$request->get('appointment_date'))->first();

        if($appointment)
            return redirect()->back()->withFlashWarning('Slot Already Booked!');

        $appointment = new Appointment();

        $appointment->patient_id            = $patient->id;
        $appointment->doctor_id             = $doctor_id;
        $appointment->appointment_date      =  $request->get('appointment_date');
        $appointment->appointment_slot      = $request->get('appointment_slot');
        $appointment->type                  = $request->get('appointment_type');
        $appointment->description           = $request->get('description');
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $appointment->save();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->back()->withFlashSuccess('Appointment Made! An SMS Will be sent for reminder on appointment day');

    }

    public function deleteAppointment(Request $request){
        $affected = Appointment::destroy($request->get('appointment_id'));
        if($affected){
            return redirect()->back()->withFlashSuccess('Appointment Deleted!');
        }

        return redirect()->back()->withFlashWarning('Unknown Error occurred!');
    }

    public function getDocFreeSlots(Request $request){
        $doctor = auth()->user();
        $slots = Appointment::where('doctor_id',$doctor->id)
                            ->where('appointment_date',$request->date)
                            ->pluck('appointment_slot');
        $allSlots = [
            "1" => '10:00 AM',
            "2" => '10:40 AM',
            "3" => '11:20 AM',
            "4" => '12:00 AM',
            "5" => '12:40 AM',
            "6" => '01:20 AM',
            "7" => '02:00 AM',
            "8" => '02:40 AM',
            "9" => '03:20 AM',
            "10" => '04:00 AM',
            "11" => '04:40 AM',
            "12" => '05:20 AM',
            "13" => '06:00 AM',
            "14" => '06:40 AM',
            "15" => '07:20 AM'
        ];
        foreach ($slots as $slot)
        {
            unset($allSlots[$slot]);
        }
        return response()->json($allSlots);
    }

    public function createDocLeaves(){

        $doctor_id = auth()->user()->id;
        //$upcomingLeaves = DoctorLeave::where('doctor_id',$doctor_id)->where('leave_date','>=',\Carbon\Carbon::now()->format('Y-m-d'))->get();
        return view('frontend.add_leave_doctor');
    }

    public function addDocLeaves(Request $request){
        dd($request->all());
    }
}
