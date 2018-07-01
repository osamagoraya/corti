<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'HomeController@index')->name('index');
Route::get('contact', 'ContactController@index')->name('contact');
Route::post('contact/send', 'ContactController@send')->name('contact.send');

//Route::get('appointment', 'AppointmentController@appointment')->name('appointment');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', 'AccountController@index')->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');
    });
    Route::resource('appointment', 'AppointmentController');
    Route::post('get/appointments/all', 'AppointmentController@getAppointments')->name('get-appointments');
    Route::post('appointment-delete/{id}', 'AppointmentController@deleteAppointments')->name('delete-appointment');

    Route::post('/doctor/create','MyDocController@createPatientByDoc')->name('doctor.create.user');
    Route::get('/doctor/create_appointemnt','MyDocController@createAppointment')->name('add.appointment.doctor');
    Route::get('/staff/create_appointemnt','MyStaffController@createAppointment')->name('get.appointment.staff');

    Route::post('/doctor/add_appointemnt','MyDocController@addAppointment')->name('create.appointment.doctor');

    Route::get('/get_patient_details','MyStaffController@getPatientDetails')->name('get.patient.details');
    Route::get('/get_doctor_details','MyStaffController@getDoctorDetails')->name('get.doctor.details');

    Route::get('/delete/appointment','MyDocController@deleteAppointment')->name('delete.doctor.appointment');

    Route::get('/get/doctor/free_slots','MyStaffController@getAppointmentTime')->name('get.appointmentTime.staff');

    Route::get('/doctor/create_leave','MyDocController@createDocLeaves')->name('create.leave.doctor');

    Route::post('/doctor/add_leave','MyDocController@addDocLeaves')->name('add.leave.doctor');


    //Staff Routes
    Route::get('/staff_add_doc','MyStaffController@addDoc')->name('add.doctor');
    Route::get('/staff_add_patient','MyStaffController@addDoc')->name('add.doctor');
    Route::get('/staff_manage_doctor','MyStaffController@listDoctors')->name('manage.doctors');
    Route::get('/staff_manage_patient','MyStaffController@listPatients')->name('manage.patients');
    Route::get('/staff/configure/{doctor}', 'MyStaffController@configureDoctor')->name('staff.configure.doctor');
    Route::post('/staff/configure/', 'MyStaffController@saveConfigurationDoctor')->name('staff.saveConfigure.doctor');
    Route::get('/staff/deleteAppointmentType/{appointmentType}', 'MyStaffController@deleteAppointmentType')->name('staff.delete.appointmentType');
    Route::post('/staff/addAppointmentType/', 'MyStaffController@addAppointmentType')->name('staff.add.appointmentType');

    Route::get('/staff/create_appointemnt','MyStaffController@createAppointment')->name('add.appointment.staff');

    Route::post('/staff/save_appointment','MyStaffController@saveAppointment')->name('save.appointment.staff');

    Route::get('/staff/appointments','MyStaffController@listAppointments')->name('staff.listing');

});
