<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                {{ __('menus.backend.sidebar.general') }}
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}"><i class="icon-speedometer"></i> {{ __('menus.backend.sidebar.dashboard') }}</a>
            </li>

            <li class="nav-title">
                {{ __('menus.backend.sidebar.system') }}
            </li>

            @if ($logged_in_user->isAdmin())


                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                {{ __('labels.backend.access.users.management') }}

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                {{ __('labels.backend.access.roles.management') }}
                            </a>
                        </li>
            @endif

            @if( $logged_in_user->isDoctor())
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link" href="{{ route('frontend.add.appointment.doctor') }}">
                    <i class="fa fa-calender"></i> {{ __('menus.backend.add_appointment') }} <!--//menus.backend.log-viewer.main -->
                </a>
            </li>
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link" href="{{ route('frontend.create.leave.doctor') }}">
                    <i class="icon-list"></i> {{ __('menus.backend.add_leave') }} <!--//menus.backend.log-viewer.main -->
                </a>
            </li>
            @endif
            @if( $logged_in_user->isStaff())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link" href="{{ route('frontend.manage.patients') }}">
                        <i class="fa fa-calender"></i> {{ __('menus.backend.manage_patients') }} <!--//menus.backend.log-viewer.main -->
                    </a>
                </li>
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link" href="{{ route('frontend.manage.doctors') }}">
                        <i class="icon-list"></i> {{ __('menus.backend.manage_doctors') }} <!--//menus.backend.log-viewer.main -->
                    </a>
                </li>
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                    <a class="nav-link" href="{{ route('frontend.add.appointment.staff') }}">
                        <i class="fa fa-plus"></i> {{ __('menus.backend.add_appointment') }} <!--//menus.backend.log-viewer.main -->
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div><!--sidebar-->