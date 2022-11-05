
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard.dashboard') }}" class="brand-link">
                <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Al-Madina Market</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                @auth
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">



                        
                        <a href="{{route('dashboard.profile.edit')}}" class="d-block">{{Auth::user()->name}}</a>
                        <br>
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                        <button type="submit" class="btn btn-info">Logout</button>
                        </form>
                       

                    </div>
                </div>  
                @endauth
                

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

               

            </div>
            <!-- /.sidebar -->
            <x-navigation/>
        </aside>