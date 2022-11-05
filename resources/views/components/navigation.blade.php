<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
        data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->

        @foreach ($items as $item)
        <li class="nav-item">
            <a href="#" class="nav-link {{Route::is($item['active'])?'active':''}}">
              <i class="{{$item['icon']}}"></i>
              <p>
                {{$item['title']}}
              </p>
              <i class="right fas fa-angle-right mr-1"></i>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item active">
                <a href="{{route($item['route'])}}" class="nav-link 
                ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{$item['title']}}</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route($item['create_route'])}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route($item['trash'])}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Trashed </p>
                </a>
              </li>
              
            </ul>
            </li>
        @endforeach
    </ul>
</nav>
<!-- /.sidebar-menu -->