@extends('frontend.layouts.app')

@section('title', app_name() . ' | Appointment')
@push('after-styles')

    <!-- Include CSS for JQuery Frontier Calendar plugin (Required for calendar plugin) -->
    <link rel="stylesheet" type="text/css" href="{{asset('')}}css/frontierCalendar/jquery-frontier-cal-1.3.2.css" />

    <!-- Include CSS for color picker plugin (Not required for calendar plugin. Used for example.) -->
    <link rel="stylesheet" type="text/css" href="{{asset('')}}css/colorpicker/colorpicker.css" />

    <!-- Include CSS for JQuery UI (Required for calendar plugin.) -->
    <link rel="stylesheet" type="text/css" href="{{asset('')}}css/jquery-ui/smoothness/jquery-ui-1.8.1.custom.css" />

    <!--
    Include JQuery Core (Required for calendar plugin)
    ** This is our IE fix version which enables drag-and-drop to work correctly in IE. See README file in js/jquery-core folder. **
    -->
    <script type="text/javascript" src="{{asset('')}}js/jquery-core/jquery-1.4.2-ie-fix.min.js"></script>

    <!-- Include JQuery UI (Required for calendar plugin.) -->
    <script type="text/javascript" src="{{asset('')}}js/jquery-ui/smoothness/jquery-ui-1.8.1.custom.min.js"></script>

    <!-- Include color picker plugin (Not required for calendar plugin. Used for example.) -->
    <script type="text/javascript" src="{{asset('')}}js/colorpicker/colorpicker.js"></script>

    <!-- Include jquery tooltip plugin (Not required for calendar plugin. Used for example.) -->
    <script type="text/javascript" src="{{asset('')}}js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js"></script>

    <!--
        (Required for plugin)
        Dependancies for JQuery Frontier Calendar plugin.
        ** THESE MUST BE INCLUDED BEFORE THE FRONTIER CALENDAR PLUGIN. **
    -->
    <script type="text/javascript" src="{{asset('')}}js/lib/jshashtable-2.1.js"></script>

    <!-- Include JQuery Frontier Calendar plugin -->
    <script type="text/javascript" src="{{asset('')}}js/frontierCalendar/jquery-frontier-cal-1.3.2.min.js"></script>

    <!--
        (Required for plugin)
        Dependancies for JQuery Frontier Calendar plugin.
        ** THESE MUST BE INCLUDED BEFORE THE FRONTIER CALENDAR PLUGIN. **
    -->
    <script type="text/javascript" src="{{asset('')}}js/lib/jshashtable-2.1.js"></script>

    <!-- Include JQuery Frontier Calendar plugin -->
    <script type="text/javascript" src="{{asset('')}}js/frontierCalendar/jquery-frontier-cal-1.3.2.min.js"></script>
    <!-- Some CSS for our example. (Not required for calendar plugin. Used for example.)-->
    @include('frontend._calender')
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col col-sm-12 align-self-center">
            <div id="example" style="margin: auto; width:75%;">


                <div id="toolbar" class="ui-widget-header ui-corner-all" style="padding:3px; vertical-align: middle; white-space:nowrap; overflow: hidden;">
                    <button id="BtnPreviousMonth">Previous Month</button>
                    <button id="BtnNextMonth">Next Month</button>
                    &nbsp;&nbsp;&nbsp;
                    Date: <input type="text" id="dateSelect" size="20"/>
                    &nbsp;&nbsp;&nbsp;
                    <!-- <button id="BtnDeleteAll">Delete All</button> -->
                </div>

                <br>

                <!--
                You can use pixel widths or percentages. Calendar will auto resize all sub elements.
                Height will be calculated by aspect ratio. Basically all day cells will be as tall
                as they are wide.
                -->
                <div id="mycal"></div>

            </div>

            <!-- debugging-->
            <div id="calDebug"></div>

            <!-- Add event modal form -->

            <div id="add-event-form" title="Add New Appointment">
                <p class="validateTips">All form fields are required.</p>
                <form>
                    <fieldset>

                        <div class="form-group">
                            <label>Avaliable Docotrs</label>
                            <select id="doctor" name="doctor_id" class="form-control" name="type">
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Type</label>
                            <select id="type" class="form-control" name="type">
                                <option value="surgery">Surgery</option>
                                <option value="normal"> Normal</option>
                            </select>
                        </div>

                        <label for="name">Description</label>
                        <input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:100%; padding: .4em;"/>
                        <table style="width:100%; padding:5px;">
                            <tr>
                                <td>
                                    <label>Start Date</label>
                                    <input type="text" name="startDate" id="startDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:100%; padding: .4em;"/>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <label>Start Hour</label>
                                    <select id="startHour" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:102%; padding: .4em;">
                                        <option value="12" SELECTED>12</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                    </select>
                                <td>
                                <td>
                                    <label>Start Minute</label>
                                    <select id="startMin" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:100%; padding: .4em;">
                                        <option value="00" SELECTED>00</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                <td>
                                <td>
                                    <label>Start AM/PM</label>
                                    <select id="startMeridiem" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:100%; padding: .4em;">
                                        <option value="AM" SELECTED>AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td>
                                    <label>Background Color</label>
                                </td>
                                <td>
                                    <div id="colorSelectorBackground"><div style="background-color: #333333; width:30px; height:30px; border: 2px solid #000000;"></div></div>
                                    <input type="hidden" id="colorBackground" value="#333333">
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <label>Text Color</label>
                                </td>
                                <td>
                                    <div id="colorSelectorForeground"><div style="background-color: #ffffff; width:30px; height:30px; border: 2px solid #000000;"></div></div>
                                    <input type="hidden" id="colorForeground" value="#ffffff">
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
            </div>

            <div id="display-event-form" title="View Agenda Item">

            </div>

            <p>&nbsp;</p>
        </div><!--col-->
    </div><!--row-->



@endsection

@push('after-scripts')
    @include('frontend._calender_scripts')
@endpush