<?php 

$sidebar = '
  <!-- BEGIN SIDEBAR -->
  <div class="page-sidebar " id="main-menu">
    <!-- BEGIN MINI-PROFILE -->
    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">
    <!-- END MINI-PROFILE -->
      <!-- BEGIN SIDEBAR MENU -->
      <ul>
        <li class="side-home">
          <a href="../home/home.php">
            <i class="material-icons">home</i>
            <span class="title">Dashboard</span>
            <span class="selected"></span>
          </a>
        </li>
        <li class="side-class">
          <a href="javascript:;"> <i class="material-icons">calendar_today</i> <span class="title">Classes</span> <span class="arrow"></span> </a>
          <ul class="sub-menu">
            <li><a href="../class/add.php">Add Class</a></li>
            <li><a href="../class/view.php">View Classes</a></li>
          </ul>
        </li>
        <li class="side-course">
          <a href="email.html"><i class="material-icons">list_alt</i> <span class="title">Courses</span> <span class="arrow"></span> </a>
          <ul class="sub-menu">
            <li><a href="../course/add.php">Add Course</a></li>
            <li><a href="../course/view.php">View Courses</a></li>
          </ul>
        </li>
        <li class="side-student">
          <a href="email.html"><i class="material-icons">people</i> <span class="title">Students</span> <span class="arrow"></span> </a>
          <ul class="sub-menu">
            <li><a href="../student/add.php">Add Student</a></li>
            <li><a href="../student/view.php">View Students</a></li>
          </ul>
        </li>
        <li class="side-major">
          <a href="email.html"><i class="material-icons">school</i> <span class="title">Majors</span> <span class="arrow"></span> </a>
          <ul class="sub-menu">
            <li><a href="../major/add.php">Add Major</a></li>
            <li><a href="../major/view.php">View Majors</a></li>
          </ul>
        </li>
        <li class="side-room">
          <a href="#"><i class="material-icons">meeting_room</i> <span class="title">Rooms</span> <span class="arrow"></span> </a>
          <ul class="sub-menu">
            <li><a href="../room/add.php">Add Room</a></li>
            <li><a href="../room/view.php">View Rooms</a></li>
          </ul>
        </li>
      </ul>
      <div class="clearfix"></div>
      <!-- END SIDEBAR MENU -->
    </div>
  </div>
  <!-- END SIDEBAR -->
';

?>