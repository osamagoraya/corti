<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Schedule;
use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\PatientCreateDocRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class MyDocController.
 */
class MyStaffController extends Controller
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

    Public function listDoctors(){
        $users = User::where('type','doctor')->paginate(10);
        return view('Frontend.list_doctors')->with('users',$users);
    }

    Public function listPatients(){
        $users = User::where('type','patient')->paginate(10);
        return view('Frontend.list_doctors')->with('users',$users);
    }

    public function configureDoctor($doctor_id){
        $doctor_data = User::find($doctor_id);
        $doctor_schedule = Schedule::where('doctor_id',$doctor_data->id)->first();
        $appointmentTypes = AppointmentType::where('doctor_id',$doctor_id)->get();
        return view('Frontend.configureDoctor')
                    ->with([
                        'doctor_data'=> $doctor_data,
                        'doctor_schedule' => $doctor_schedule,
                        'appointmentTypes' => $appointmentTypes
                    ]);
    }

    public function saveConfigurationDoctor(Request $request){
        $data = $request->except('_token');
        $schedule = Schedule::where('doctor_id',$request->doctor_id)->first();
        if($schedule){
            $schedule->update($data);
            $schedule->save();
            $schedule->fresh();
            return redirect()->back()->withFlashSuccess('Schedule Updated!');
        }
        $schedule = new Schedule();
        $schedule->insert($data);
        $schedule->save();
        $schedule->fresh();
        return redirect()->back()->withFlashSuccess('Schedule Created!');
    }

    public function deleteAppointmentType($appointmentTypeID){
        $doctor_id = AppointmentType::find($appointmentTypeID)->doctor_id;
        $result = AppointmentType::destroy($appointmentTypeID);
        if($result){
            return redirect()->route('frontend.staff.configure.doctor',['doctor'=>$doctor_id])->withFlashSuccess('Appointment Type Removed');
        }
        return redirect()->back()->withFlashWarning('Unable To Delete Appointment Type');
    }

    public function addAppointmentType(Request $request){
        $result = AppointmentType::firstOrNew([
            'doctor_id' => $request->doctor_id,
            'minutes'  => $request->minutes
        ]);
        $result->save();
        if($result){
            return redirect()->route('frontend.staff.configure.doctor',['doctor'=>$request->doctor_id])->withFlashSuccess('Appointment Type Added');
        }
        return redirect()->back()->withFlashWarning('Unable To ADD Appointment Type');
    }

    public function createPatientByStaff(PatientCreateDocRequest $request){
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email = $request->email;
        $user->type = 'patient';

        $user->save();
        return redirect()->back()->withFlashSuccess('Patient Created Successfully');
    }

    public function createDoctorByStaff(StaffCreateDocRequest $request){
        $user = new User();

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email = $request->email;
        $user->type = 'patient';

        $user->save();
        return redirect()->back()->withFlashSuccess('Patient Created Successfully');
    }

    public function createAppointment(){
        $users = User::where('type','patient')->pluck('last_name','id');
        $doctors = User::where('type','doctor')->pluck('last_name','id');
        return view('frontend.add_appointment_staff')->with('users',$users)->with('doctors',$doctors);
    }

    public function getPatientDetails(Request $request){
        $patient = User::where('id',$request->user_id)->first();
        return response()->json($patient);
    }
    public function getDoctorDetails(Request $request){
        $doctor = User::where('id',$request->user_id)->first();
        $durations = AppointmentType::where('doctor_id',$request->user_id)->get();
        return response()->json([$doctor,$durations]);
    }

    public function getAppointmentTime(Request $request){
        $lastAppointment = Appointment::where('appointment_date',$request->date)
                            ->where('doctor_id',$request->doctor_id)
                            ->orderBy('starting_time','desc')->first();

        $day_start = strtolower(Carbon::parse($request->date)->format('l')).'_start';
        $day_end = strtolower(Carbon::parse($request->date)->format('l')).'_end';
        $doctor_start_time = Schedule::where('doctor_id',$request->doctor_id)->first()->$day_start;
        $doctor_end_time = Schedule::where('doctor_id',$request->doctor_id)->first()->$day_end;

        //Case when already there are already appointments for the date
        if($lastAppointment){
            if(Carbon::parse($lastAppointment->ending_time)->addMinutes($request->appointment_minutes)->gt(Carbon::parse($doctor_end_time))  ){
                return [
                    'status' => false,
                    'message' => 'Appointment Exceeds Doctor Ending hours'
                ];
            }
            return [
                'status' => true,
                'appointment_time' => Carbon::parse($lastAppointment->ending_time)->toTimeString()
            ];
        }
        //Case when there is no appointment already

        if(Carbon::parse($doctor_start_time)->addMinutes($request->appointment_minutes)->gt(Carbon::parse($doctor_end_time))  ){
            return [
                'status' => false,
                'message' => 'Appointment Exceeds Doctor Ending hours'
            ];
        }

        return [
            'status' => true,
            'appointment_time' => $doctor_start_time
        ];

    }

    public function saveAppointment(Request $request) {
       $result = Appointment::insert([
            'patient_id' => $request->user_id_patient,
            'doctor_id'  => $request->user_id_doctor,
            'appointment_date' => $request->appointment_date,
            'starting_time' => $request->appointment_start_time,
            'appointment_durations' => $request->appointment_duration_type,
            'ending_time' => Carbon::parse($request->appointment_start_time)->addMinutes($request->appointment_duration_type),
            'appointment_added_by' => auth()->user()->id,
            'type' => $request->appointment_type,
            'description'      => $request->description

        ]);
       if($result){
           return redirect()->route('backend.admin.dashboard')->withFlashSuccess('Appointment Created Successfully');
       }
        return redirect()->back()->withFlashWarning('Error Creating Appointment');
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

    public function createDocLeaves(){

        $doctor_id = auth()->user()->id;
        //$upcomingLeaves = DoctorLeave::where('doctor_id',$doctor_id)->where('leave_date','>=',\Carbon\Carbon::now()->format('Y-m-d'))->get();
        return view('frontend.add_leave_doctor');
    }

    public function addDocLeaves(Request $request){
        dd($request->all());
    }
}
