
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light navbar-white  ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
          <a href="<?php echo $base_url;?>/settings/profile" class="dropdown-item">
             <i class="fas fa-user-cog"></i> Profile
          </a>
          <a href="<?php echo $base_url;?>/logOut" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        
          
        </div>
      </li>
      
      
    </ul>
  </nav>
  <!-- /.navbar -->
