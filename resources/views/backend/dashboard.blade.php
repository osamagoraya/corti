@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('strings.backend.dashboard.welcome') }} {{ $logged_in_user->name }}!</strong>
                    @if ($logged_in_user->isDoctor())
                    <button type="button" id="create_user" class="btn btn-info pull-right" data-toggle="modal" data-target="#exampleModal">Create User</button>
                    @endif
                </div><!--card-header-->
                <div class="card-block">
                    <div class="card-body">
                        @if ($logged_in_user->isDoctor())
                        <table id="datatable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Duration</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{$appointment->patient->name}}</td>
                                        <td>{{$appointment->appointment_date}}</td>
                                        <td>{{ $appointment->starting_time }}</td>
                                        <td>{{ $appointment->appointment_durations }}</td>
                                        <td><span class="badge {{($appointment->type == 'surgery') ? 'badge-danger': 'badge-warning'}}">{{ucfirst($appointment->type)}}</span></td>
                                        <td><a href="{{ route('frontend.delete.doctor.appointment',['appointment_id'=>$appointment->id]) }}"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                            @if ($logged_in_user->isStaff())
                                <table id="datatable" class="table table-responsive-sm table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{$appointment->patient->name}}</td>
                                            <td>{{$appointment->doctor->name}}</td>
                                            <td>{{$appointment->appointment_date}}</td>
                                            <td>{{ $appointment->starting_time }}</td>
                                            <td>{{ $appointment->appointment_durations }}</td>
                                            <td><span class="badge {{($appointment->type == 'surgery') ? 'badge-danger': 'badge-warning'}}">{{ucfirst($appointment->type)}}</span></td>
                                            <td><a href="{{ route('frontend.delete.doctor.appointment',['appointment_id'=>$appointment->id]) }}"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                            @if ($logged_in_user->isAdmin())
                                <p>Please select an option from sidebar.</p>
                           @endif
                    </div>
                </div><!--cardblock-->
            </div><!--card-->
        </div><!--col-->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{route('frontend.doctor.create.user')}}">
                        {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <strong>Patient Account</strong>
                                    <small>Create</small>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="firstname">Frist Name</label>
                                        <input type="text" class="form-control" name="first_name" id="firstname" placeholder="Enter patient's first name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="lastname" placeholder="Enter patient's last name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Last Name</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter patient's email" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--row-->

@endsection
@push('after-scripts')
    <script>
        $(function(){
            $('#datatable').DataTable();
        })
    </script>
@endpush
