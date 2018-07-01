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
                        <form method="POST" action="{{route('frontend.add.leave.doctor')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="last_name">From Date</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input required type='text' name="from_leave_date" id="from_leave_date" class="form-control" style="width: 100%;" />
                                    <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name">To Date</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' name="to_leave_date" id="to_leave_date" class="form-control" style="width: 100%;" />
                                    <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                                <small>For one day leave don't select this field.</small>
                            </div>

                            <button type="submit" class="btn btn-primary pull-right">Add Leave</button>

                        </form>
                    </div>

                </div><!--card-block-->
            </div><!--card-->
        </div><!--col-->
        <div class="col-lg-5">
            <div class="card col-lg-12" style="margin-left: 5%">
                <div class="card-header">
                    <strong>Your Upcoming Leaves</strong>
                </div><!--card-header-->
                <div class="card-block">
                    <div class="card-body" >
                        <table class="table table-border">
                            <thead>
                            <tr>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                            </tr>
                            </tbody>

                        </table>
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

            $('#datetimepicker2').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                orientation: "auto",
                startDate: "{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
            });

            $('#datetimepicker1').on('change',function () {
                var date = $('input[name="appointment_date"]').val();
                $.ajax({
                    url : "{{ route('frontend.get.doctor.freeSlots') }}",
                    method: "GET",
                    data : { date: date},
                    success: function (response) {
                        $('#free_slots').empty();
                        var str="";
                        $.each(response,function (index,value) {
                            str += '<li>'+value+'</li>';
                        });
                        $('#free_slots').append(str);
                    },
                    error:function () {
                        swal("Unable To GET Free Slots")
                    }
                });
            });

            $('.select2').select2();
//Property change method
            $('select[name="user_id"]').change(function() {

                var user_id = $(this).val();
                if(user_id != ''){
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('frontend.get.user.details') }}',
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
