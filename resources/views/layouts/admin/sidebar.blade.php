<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('admin-lte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="{{asset('admin-lte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library catatan ( 'menu-open' ) untuk navbar aktif-->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-header">Server</li>
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>
                            Pengaturan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('pengaturan.user.index')}}" class="nav-link">
                                <i class="fa fa-users-cog users nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-cogs"></i>
                                <p>
                                    Permissions
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('pengaturan.module-permission.index')}}" class="nav-link">
                                        {{-- <i class="fa fa-users-cog users nav-icon"></i> --}}
                                        <p>Module Permission</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('pengaturan.sub-module-permission.index')}}" class="nav-link">
                                        {{-- <i class="fa fa-users-cog users nav-icon"></i> --}}
                                        <p>Sub Module Permission</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('pengaturan.permission.index')}}" class="nav-link ">
                                        {{-- <i class="fa fa-users-cog users nav-icon"></i> --}}
                                        <p>Permission</p>
                                    </a>
                                </li>                                
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('pengaturan.role.index')}}" class="nav-link">
                                <i class="fa fa-users-cog users nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
