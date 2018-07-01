@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card col-lg-12">
                <div class="card-header">
                    <strong>{{ __('strings.backend.dashboard.welcome') }} {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-block">
                    <div class="card-body" >
                        <form method="POST" action="{{route('frontend.create.appointment.doctor')}}">
                            {{ csrf_field() }}
                             <div class="form-group">
                                  <label for="firstname">Enter Patient Last Name</label>
                                 {!! Form::select('user_id', $users, null, ['class'=>'select-box3 form-control select2','placeholder'=>'Please Select a Patient']) !!}
                             </div>
                             <div class="form-group">
                                   <label for="first_name">Fast Name</label>
                                   <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Patient's First Name" required>
                             </div>
                             <div class="form-group">
                                   <label for="last_name">Email</label>
                                   <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Patient's Last Name" required>
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
                                <small>After selecting date please see free slots on left.</small>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Appointment Time</label>
                                <div class="row">
                                <div class="col-lg-12">
                                    <select class="form-control" name="appointment_slot">
                                    </select>
                                </div>
                                </div>
                            </div>

                                <button type="submit" class="btn btn-primary pull-right">Make Appointment</button>

                        </form>
                    </div>

                </div><!--card-block-->
            </div><!--card-->
        </div><!--col-->
        <div class="col-lg-5">
            <div class="card col-lg-12" style="margin-left: 5%">
                <div class="card-header">
                    <strong>Free Slots</strong>
                </div><!--card-header-->
                <div class="card-block">
                    <div class="card-body" >
                        <p>Select Date From Left Panal to View Free Slots</p>
                        <ul id="free_slots"></ul>
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


$('.select2').select2();
//Property change method
    $('select[name="user_id"]').change(function() {

        var user_id = $(this).val();
        if(user_id != ''){
            $.ajax({
                type: 'GET',
                url: '{{ route('frontend.get.patient.details') }}',
                data: { user_id : user_id}
            }).done(function (data) {
                console.log(data['first_name']);
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
            });
        }
    });

});
</script>
@endpush
