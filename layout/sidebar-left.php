  <!-- Main Sidebar Container -->
  <aside class="main-sidebar <?php echo ($_SESSION['user'][4]=='dark')?'sidebar-dark-primary':'sidebar-light-primary'; ?> elevation-1 sidebar-no-expand">
        <!-- Brand Logo -->
    <a href="<?php echo $base_url;?>/dashboard" class="brand-link">
      

      <img src="<?php echo $base_url;?>/dist/img/AdminLTELogo.png" alt="Crypto Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AIMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $_SESSION['user'][5];?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo $base_url;?>/settings/profile" class="d-block"><?php echo $_SESSION['user'][1];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo $base_url;?>/dashboard" class="nav-link" id="dashboard" title="Dashboard">
              <i class="fas fa-chart-line"></i>
              <p>
                Dashboard

              </p>
            </a>
          </li>
          <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="Admin") ) {
          ?>
          <li class="nav-item menu-close" id="institutes">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-building"></i> 
              <p>
                Institute Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/institute/newInstitute" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Institute</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/institute/viewInstitutes" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Institutes</p>
                </a>
              </li>
            </ul>
          </li>
           <?php
          }
          ?>
           <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="Admin") ) {
          ?>
          <li class="nav-item menu-close" id="users">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-users"></i> 
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/users/newUser" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New User</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/users/viewUsers" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Users</p>
                </a>
              </li>
            </ul>
          </li>
         <?php
          }
          ?>
         <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
          ?>
          <li class="nav-item menu-close" id="lecturers">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas  fa-user-tie"></i> 
              <p>
                Lecturer Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/lecturers/newLecturer" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Lecturer</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/lecturers/viewLecturers" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Lecturers</p>
                </a>
              </li>
            </ul>
          </li>
         <?php
          }
          ?>
           <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
          ?>
          <li class="nav-item menu-close" id="courses">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas  fa-graduation-cap"></i> 
              <p>
                Course Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/courses/newCourse" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Course</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/courses/viewCourses" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Courses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/courses/manageSubjects" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subject Management</p>
                </a>
              </li>
            </ul>
          </li>
         <?php
          }
          ?>
           <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
          ?>
          <li class="nav-item menu-close" id="students">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-book-reader"></i> 
              <p>
                Student Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/students/newBatch" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Batch</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/students/viewBatches" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Batches</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/students/manageStudents" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Management</p>
                </a>
              </li>
            </ul>
          </li>
         <?php
          }
          ?>
          <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
          ?>
          <li class="nav-item menu-close" id="exams">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas  fas fa-award"></i> 
              <p>
                Exam Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/exams/newExam" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Exam</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/exams/viewExams" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Exams</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/exams/manageResults?exam_id=" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Result Management</p>
                </a>
              </li>
            </ul>
          </li>
         <?php
          }
          ?>
          <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
          ?>
          <li class="nav-item menu-close" id="payments">
            <a href="#" class="nav-link ">
              <i class="nav-icon  fas fa-money-bill-wave"></i> 
              <p>
                Payment Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/payments/newPayment" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Payment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/payments/viewPayments" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Payments</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/payments/managePayments?payment_id=" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Paid Details</p>
                </a>
              </li>
            </ul>
          </li>
         <?php
          }
          ?>
           <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
          ?>
          <li class="nav-item menu-close" id="posts">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-comment-alt"></i> 
              <p>
                Post Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $base_url;?>/posts/newPost" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Post</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo $base_url;?>/posts/viewPosts" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Posts</p>
                </a>
              </li>
            </ul>
          </li>
         <?php
          }
          ?>
          <?php
          if(isset($_SESSION['user']) && ($_SESSION['user'][2]=="User") ) {
          ?>
          <li class="nav-item">
            <a href="<?php echo $base_url;?>/complaints/" class="nav-link" id="complaints" title="Complaints">
              <i class="fas fa-edit"></i>
              <p>
                Complaints

              </p>
            </a>
          </li>
           <?php
          }
          ?>
          <li class="nav-item">
            <a href="<?php echo $base_url;?>/settings/" class="nav-link" id="settings" title="Settings">
              <i class="fas fa-user-cog"></i>
              <p>
                Settings

              </p>
            </a>
          </li>

          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>