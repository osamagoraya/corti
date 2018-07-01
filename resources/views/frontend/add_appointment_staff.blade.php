@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col-lg-6" style="margin-left: 25%">
            <div class="card col-lg-12">
                <div class="card-header">
                    <strong>{{ __('strings.backend.dashboard.welcome') }} {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-block">
                    <div class="card-body" >
                        <form id="appointment-form" method="POST" action="{{route('frontend.save.appointment.staff')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="firstname">Enter Patient's Last Name</label>
                                {!! Form::select('user_id_patient', $users, null, ['class'=>'select-box3 form-control select2','placeholder'=>'Please Select a Patient']) !!}
                            </div>
                            <div class="form-group">
                                <label for="first_name">Patient's First Name</label>
                                <input type="text" class="form-control" name="first_name_patient" id="first_name_patient" placeholder="Patient's First Name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Patient's Email</label>
                                <input type="text" class="form-control" name="email_patient" id="email_patient" placeholder="Patient's Last Name" required>
                            </div>
                            <div class="form-group">
                                <label for="firstname">Enter Doctor's Last Name</label>
                                {!! Form::select('user_id_doctor', $doctors, null, ['class'=>'select-box3 form-control select2','placeholder'=>'Please Select a Dcotor']) !!}
                            </div>
                            <div class="form-group">
                                <label for="first_name">Doctor's First Name</label>
                                <input type="text" class="form-control" name="first_name_doctor" id="first_name_doctor" placeholder="Patient's First Name" required>
                            </div>
                            <div class="form-group">
                                <label for="first_name">Doctor's Email</label>
                                <input type="text" class="form-control" name="email_doctor" id="email_doctor" placeholder="Patient's First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Doctor's Appointment Durations in Minutes</label>
                                <select class="form-control" name="appointment_duration_type" id="appointment_duration_type" placeholder="Select Doctor To See Appointment Durations" required>
                                </select>
                                <small>Can be configured in Doctor Management Section</small>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Appointment Type</label>
                                <select class="form-control" name="appointment_type" id="appointment_type" placeholder="Patient's Appointment Type" required>
                                    <option disabled selected val="0">Please select an option</option>
                                    <option val="normal">Normal</option>
                                    <option val="surgery">Surgery</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" row="6" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Appointment Date</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name="appointment_date" id="appointment_date" class="form-control" style="width: 100%;" />
                                    <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                                <small>After selecting date available slot will appear.</small>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Appointment Time</label>
                                <div class="row input-group">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control available-appointment-time" disabled >
                                        <input name="appointment_start_time" type="hidden" class="form-control available-appointment-time"  >
                                    </div>
                                </div>
                            </div>

                            <button id="btn-submit" type="submit" class="btn btn-primary pull-right">Make Appointment</button>

                        </form>
                    </div>

                </div><!--card-block-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->

@endsection
@push('after-scripts')
    <script>
        $(document).ready(function() {
            $('#datetimepicker1').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                orientation: "auto",
                startDate: "{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
            });

            $('#datetimepicker1').on('change', function () {
                var date = $('input[name="appointment_date"]').val();
                var patient_id = $('select[name="user_id_patient"]').val();
                var doctor_id = $('select[name="user_id_doctor"]').val();
                var appointment_minutes = $('select[name="appointment_duration_type"]').val();

                if( date == '' | patient_id == '' | doctor_id == '' | appointment_minutes == ''){
                    swal("Please Enter The Required Details");
                    return;
                }

                $.ajax({
                    url: "{{ route('frontend.get.appointmentTime.staff') }}",
                    method: "GET",
                    data: {date: date,patient_id: patient_id,doctor_id: doctor_id,appointment_minutes: appointment_minutes},
                    success: function (response) {
                        swal('Available Appointment Time:\n' + response.appointment_time)
                        $('.available-appointment-time').val(response.appointment_time)
                    },
                    error: function () {
                        swal("Internal Server Error!")
                    }
                });
            });

            $('#appointment-form').on('submit',function () {
                if( $('#available-appointment-time').val != ''){
                    this.submit()
                }
            });

            $('.select2').select2();

            $('select[name="user_id_patient"]').change(function () {

                var user_id = $(this).val();
                if (user_id != '') {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('frontend.get.patient.details') }}',
                        data: {user_id: user_id}
                    }).done(function (data) {
                        $('#first_name_patient').val(data.first_name);
                        $('#email_patient').val(data.email);
                    });
                }
            });

            $('select[name="user_id_doctor"]').change(function () {

                var user_id = $(this).val();
                if (user_id != '') {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('frontend.get.doctor.details') }}',
                        data: {user_id: user_id}
                    }).done(function (data) {
                        $('#first_name_doctor').val(data[0].first_name);
                        $('#email_doctor').val(data[0].email);

                        var str = '';
                        $('select[name="appointment_duration_type"]').html("");
                        data[1].forEach(function (item) {
                            str += '<option>' + item.minutes +'</option>'
                        })
                        $('select[name="appointment_duration_type"]').html(str);


                    });
                }

            });
        });
    </script>
@endpush
