<?php

Breadcrumbs::register('admin.auth.user.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(__('labels.backend.access.users.management'), route('admin.auth.user.index'));
});

Breadcrumbs::register('admin.auth.user.deactivated', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.user.index');
    $breadcrumbs->push(__('menus.backend.access.users.deactivated'), route('admin.auth.user.deactivated'));
});

Breadcrumbs::register('admin.auth.user.deleted', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.user.index');
    $breadcrumbs->push(__('menus.backend.access.users.deleted'), route('admin.auth.user.deleted'));
});

Breadcrumbs::register('admin.auth.user.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.auth.user.index');
    $breadcrumbs->push(__('labels.backend.access.users.create'), route('admin.auth.user.create'));
});

Breadcrumbs::register('admin.auth.user.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.user.index');
    $breadcrumbs->push(__('menus.backend.access.users.view'), route('admin.auth.user.show', $id));
});

Breadcrumbs::register('admin.auth.user.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.user.index');
    $breadcrumbs->push(__('menus.backend.access.users.edit'), route('admin.auth.user.edit', $id));
});

Breadcrumbs::register('admin.auth.user.change-password', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.auth.user.index');
    $breadcrumbs->push(__('menus.backend.access.users.change-password'), route('admin.auth.user.change-password', $id));
});

Breadcrumbs::register('frontend.add.appointment.doctor', function ($breadcrumbs) {

    $breadcrumbs->push(__('menus.backend.add_appointment'), route('frontend.add.appointment.doctor'));
});
Breadcrumbs::register('frontend.create.leave.doctor', function ($breadcrumbs) {

    $breadcrumbs->push(__('menus.backend.add_appointment'), route('frontend.create.leave.doctor'));
});
Breadcrumbs::register('frontend.manage.doctors', function ($breadcrumbs) {

    $breadcrumbs->push(__('menus.backend.manage_doctors'), route('frontend.manage.doctors'));
});
Breadcrumbs::register('frontend.manage.patients', function ($breadcrumbs) {

    $breadcrumbs->push(__('menus.backend.manage_patients'), route('frontend.manage.patients'));
});
Breadcrumbs::register('frontend.staff.configure.doctor', function ($breadcrumbs) {

    $breadcrumbs->push(__('menus.backend.configure_doctor'), route('frontend.manage.patients'));
});
Breadcrumbs::register('frontend.add.appointment.staff', function ($breadcrumbs) {

    $breadcrumbs->push(__('menus.backend.add_appointment'), route('frontend.add.appointment.staff'));
});
//
