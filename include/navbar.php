<?php 

$navbar = '
  <!-- BEGIN HEADER -->
  <div class="header navbar navbar-inverse ">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
      <div class="header-seperation">
        <ul class="nav pull-left notifcation-center visible-xs visible-sm">
          <li class="dropdown">
              <a href="#main-menu" data-webarch="toggle-left-side">
                <i class="material-icons">menu</i>
              </a>
          </li>
        </ul>
        <!-- BEGIN LOGO -->
        <a>
          <img src="../../assets/img/logo.png" class="logo" alt="" data-src="../../assets/img/logo.png" data-src-retina="../../assets/img/logo2x.png" width="106" height="21" />
        </a>
        <!-- END LOGO -->
        <ul class="nav pull-right notifcation-center">
          <li class="dropdown hidden-xs hidden-sm">
              <a href="../home/home.php" class="dropdown-toggle active" data-toggle="">
                <i class="material-icons">home</i>
              </a>
          </li>
        </ul>
      </div>
      <!-- END RESPONSIVE MENU TOGGLER -->
      <div class="header-quick-nav">
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="pull-left">
          <ul class="nav quick-section">
            <li class="quicklinks">
              <a href="#" class="" id="layout-condensed-toggle">
                <i class="material-icons">menu</i>
              </a>
            </li>
          </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
        <!-- BEGIN CHAT TOGGLER -->
        <div class="pull-right">
          <ul class="nav quick-section">
            <li class="quicklinks">
              <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">
                <i class="material-icons">settings</i>
              </a>
              <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
                <li>
                  <a href="user-profile.html">My Account</a>
                </li>
                <li>
                  <a href="login.html"><i class="material-icons">power_settings_new</i>&nbsp;&nbsp;Log Out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- END CHAT TOGGLER -->
      </div>
      <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
  </div>
  <!-- END HEADER -->
';

?>