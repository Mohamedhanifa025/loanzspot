{{--
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('img/logo-white.svg') }}" alt="{{ trans('global.site_title') }}" />
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" class="nav-link">
                        <p>
                            <i class="fas fa-tachometer-alt">

                            </i>
                            <span>{{ trans('global.dashboard') }}</span>
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle">
                            <i class="fas fa-users">

                            </i>
                            <p>
                                <span>{{ trans('global.userManagement.title') }}</span>
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('global.permission.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fas fa-briefcase">

                                        </i>
                                        <p>
                                            <span>{{ trans('global.role.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fas fa-user">

                                        </i>
                                        <p>
                                            <span>{{ trans('global.user.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                --}}
{{--@can('product_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.products.index") }}" class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                            <i class="fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('global.product.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan--}}{{--


                <li class="nav-item">
                    <a href="{{ route("admin.customer.index") }}" class="nav-link {{ request()->is('admin/customer') || request()->is('admin/customer/*') ? 'active' : '' }}">
                    <i class="fa fa-users" aria-hidden="true">

                    </i>
                    <p>
                        <span>{{ trans('Customers') }}</span>
                    </p>

                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route("admin.notification.index") }}" class="nav-link">
                        <i class="fas fa-bell" aria-hidden="true">

                        </i>
                        <p>
                            <span>{{ trans('Notifications') }}</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route("admin.contact.index") }}" class="nav-link">
                        <i class="fas fa-address-book" aria-hidden="true">

                        </i>
                        <p>
                            <span>{{ trans('Contacts') }}</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route("admin.loan.index") }}" class="nav-link">
                        <i class="fa fa-address-card" aria-hidden="true">

                        </i>
                        <p>
                            <span>{{ trans('Apply_loans') }}</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route("admin.referral.index") }}" class="nav-link">
                         <i class="fas fa-sync" aria-hidden="true">

                         </i>
                         <p>
                            <span>{{ trans('Referrals') }}</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route("admin.setting.index") }}" class="nav-link">
                         <i class="fas fa-cogs" aria-hidden="true">

                         </i>
                         <p>
                            <span>{{ trans('Settings') }}</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <i class="fas fa-sign-out-alt">

                            </i>
                            <p>
                                <span>{{ trans('global.logout') }}</span>
                            </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
--}}
<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="dashboard">
                <img src="{{ asset('assets/img/logo.svg') }}" class="navbar-brand-img" alt="Logo">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("admin.home") }}">
                            <i class="fa fa-tachometer-alt"></i>
                            <span class="nav-link-text">{{ trans('global.dashboard') }}</span>
                        </a>
                    </li>
                    @can('user_management_access')
                        <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                            <a class="nav-link nav-dropdown-toggle">
                                <i class="fas fa-users"></i>
                                    <span class="nav-link-text">{{ trans('global.userManagement.title') }}</span>
                                    <i class="right fa fa-angle-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('permission_access')
                                    <li class="nav-item">
                                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                            <i class="fas fa-unlock-alt"></i>
                                                <span class="nav-link-text">{{ trans('global.permission.title') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('role_access')
                                    <li class="nav-item">
                                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                            <i class="fas fa-briefcase"></i>
                                            <span class="nav-link-text">{{ trans('global.role.title') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('user_access')
                                    <li class="nav-item">
                                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                            <i class="fas fa-user"></i>
                                            <span class="nav-link-text">{{ trans('global.user.title') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link href="{{ route("admin.customer.index") }}">
                            <i class="fa fa-users"></i>
                                <span class="nav-link-text">{{ trans('global.customer.title') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link href="{{ route("admin.contact.index") }}">
                            <i class="fas fa-address-book" aria-hidden="true"></i>
                            <span class="nav-link-text">{{ trans('global.contact.title') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link href="{{ route("admin.notification.index") }}">
                            <i class="fas fa-bell" aria-hidden="true"></i>
                            <span class="nav-link-text">{{ trans('global.notification.title') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("admin.loan.index") }}">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-link-text">{{ trans('global.loan.title') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("admin.referral.index") }}">
                            <i class="fas fa-sync" aria-hidden="true"></i>
                            <span class="nav-link-text">{{ trans('global.referral.title') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("admin.setting.index") }}">
                            <i class="fas fa-cogs" aria-hidden="true"></i>
                            <span class="nav-link-text">{{ trans('global.setting.title') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="edit-profile">
                            <i class="fa fa-user"></i>
                            <span class="nav-link-text">{{ trans('global.user.my_profile') }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-link-text">{{ trans('global.logout') }}</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>
