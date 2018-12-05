
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3</title>

 <link rel="stylesheet" href="{{ asset('/css/app.css')}}">
 
 
 </head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Header  -->

  <Myheader></Myheader>
  <!-- Header  ends -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/home" class="brand-link">
      <img src="image/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="image/profile/{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fab fa-dashcube"></i>
              <p>
                Dashboard
                
              </p>
            </router-link>
          </li>
          @can('isAdmin')
          <li class="nav-item">
            <router-link to="/user" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                
              </p>
            </router-link>
          </li>
          {{-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Management
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="fas fa-circle-notch"></i>
                  <p>Active Page</p>
                </a>
              </li>
            </ul>
          </li> --}}
          <li class="nav-item">
            <router-link to="/orders" class="nav-link">
              <i class="nav-icon fas fa-list-ul"></i>
              <p>
                Orders
          
              </p>
            </router-link>
          </li>
          @endcan
          @can('isUser')
            <li class="nav-item">
              <router-link to="/create-order" class="nav-link">
                <i class="nav-icon fa fa-truck"></i>
                <p>
                  Create Order
            
                </p>
              </router-link>
          @endcan
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user-ninja"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                {{ __('Logout') }}
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
  </aside>
  <!-- /.sidebar ends -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    
    <router-view></router-view>
    <vue-progress-bar></vue-progress-bar>

  
  </div>
  <!-- /.content-wrapper -->



    <!-- Main Footer -->
    
    <Myfooter></Myfooter>
    <!-- footer ends  -->
</div>
<!-- ./wrapper ends -->

<!-- REQUIRED SCRIPTS -->



@auth
<script>

  window.user = @json(auth()->user())
  // window.user = JSON.parse(auth()->user());
  
  </script>
@endauth

<script src={{asset("/js/app.js")}}></script>


</body>
</html>
