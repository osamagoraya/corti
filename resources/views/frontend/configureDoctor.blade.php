@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card col-lg-12">
                <div class="card-header">
                    <strong>Add/Update Schedule</strong>
                </div><!--card-header-->
                <div class="card-block">
                    <div class="card-body" >
                        <form method="POST" action="{{route('frontend.staff.saveConfigure.doctor')}}">
                            {{ csrf_field() }}
                            <input name="doctor_id" type="hidden" value="{{$doctor_data->id}}">
                            <div class="form-group">
                                <label for="last_name">Doctor Name: </label>
                                <div class='input-group date'>
                                    <input disabled value="{{$doctor_data->last_name . " " . $doctor_data->first_name}}" type='text' name="doctor_name" id="from_leave_date" class="form-control" style="width: 100%;" />
                                    <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width: 45%">
                                        <span class="input-group-text" style="width:  98%;" id=""><b><i>Monday</i></b>&nbsp;Starting and Ending Hours</span>
                                    </div>
                                    <input name="monday_start" type="time" value="{{$doctor_schedule->monday_start ?? ''}}" class="form-control">
                                    <input name="monday_end"   type="time"   value="{{$doctor_schedule->monday_end ?? ''}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width: 45%">
                                        <span class="input-group-text" style="width:  98%;"><b><i>Tuesday</i></b>&nbsp;Starting and Ending Hours</span>
                                    </div>
                                    <input name="tuesday_start" type="time" value="{{$doctor_schedule->tuesday_start ?? ''}}" class="form-control">
                                    <input name="tuesday_end" type="time"   value="{{$doctor_schedule->tuesday_end ?? ''}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width: 45%">
                                        <span class="input-group-text" style="width:  98%;"><b><i>Wednesday</i></b>&nbsp;Starting and Ending Hours</span>
                                    </div>
                                    <input name="wednesday_start" type="time" value="{{$doctor_schedule->wednesday_start ?? ''}}" class="form-control">
                                    <input name="wednesday_end"   type="time" value="{{$doctor_schedule->wednesday_end ?? ''}}"   class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width: 45%">
                                        <span class="input-group-text" style="width:  98%;"><b><i>Thursday</i></b>&nbsp;Starting and Ending Hours</span>
                                    </div>
                                    <input name="thursday_start" type="time" value="{{$doctor_schedule->thursday_start ?? ''}}" class="form-control">
                                    <input name="thursday_end"   type="time" value="{{$doctor_schedule->thursday_end ?? ''}}"   class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width: 45%">
                                        <span class="input-group-text" style="width:  98%;"><b><i>Friday</i></b>&nbsp;Starting and Ending Hours</span>
                                    </div>
                                    <input name="friday_start" type="time" value="{{$doctor_schedule->friday_start ?? ''}}" class="form-control">
                                    <input name="friday_end"   type="time"   value="{{$doctor_schedule->friday_end ?? ''}}"    class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width: 45%">
                                        <span class="input-group-text" style="width:  98%;"><b><i>Saturday</i></b>&nbsp;Starting and Ending Hours</span>
                                    </div>
                                    <input name="saturday_start" type="time" value="{{$doctor_schedule->saturday_start ?? ''}}" class="form-control">
                                    <input name="saturday_end" type="time" value="{{$doctor_schedule->saturday_end ?? ''}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend" style="width: 45%">
                                        <span class="input-group-text" style="width:  98%;"><b><i>Sunday</i></b>&nbsp;Starting and Ending Hours</span>
                                    </div>
                                    <input name="sunday_start" type="time" value="{{$doctor_schedule->sunday_start ?? ''}}" class="form-control">
                                    <input name="sunday_end"  type="time" value="{{$doctor_schedule->sunday_end ?? ''}}" class="form-control">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary pull-right">SAVE</button>

                        </form>
                    </div>

                </div><!--card-block-->
            </div><!--card-->
        </div><!--col-->
        <div class="col-lg-5">
            <div class="card col-lg-12" style="margin-left: 5%">
                <div class="card-header">
                    <strong class="pull-left">Add/Remove Appointments Type</strong>
                    <!-- Button trigger modal -->
                    <button class="pull-right" type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                        <span><i class="green fa fa-plus"></i></span>
                    </button>
                </div><!--card-header-->
                <div class="card-block">
                    <div class="card-body" >
                        <table class="table table-border">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Duration(minutes)</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointmentTypes as $type)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$type->minutes}}</td>
                                <td><a class="btn btn-danger btn-sm" href="/staff/deleteAppointmentType/{{$type->id}}">Delete</a></td>
                            </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div><!--card-block-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Appoint Type Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('frontend.staff.add.appointmentType')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="doctor_id" value="{{$doctor_data->id}}">
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <input type="number" name="minutes" class="form-control" placeholder="40" aria-label="Appointment Duration" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Minutes</span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

            $('#datetimepicker2').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                orientation: "auto",
                startDate: "{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
            });



            $('.select2').select2();

        });
    </script>
@endpush
