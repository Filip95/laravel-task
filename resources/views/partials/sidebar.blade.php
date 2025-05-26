<ul class="sidebar-menu">
    @can('user-management')
        <li class="treeview">
            <a href="#"><i class= "fa fa-users"></i><span>User Management</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treview-menu">
                <li><a href="{{ route('users.index') }}">Users</a></li>
                <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
            </ul>
        </li>
    @endcan

    @can('import-data')
        <li><a href="#"><i class="fa fa-upload"></i><span>Data Import</span></a></li>
    @endcan

    <li class="treview">
        <a href="#"><i class="fa fa-table"></i><span>Imported Data</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
        </ul>
    </li>
