
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="index.php" class="site_title"><span><img src="../img/panel_logo.png" /></span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
      
      <div class="profile_info">
        <span>Welcome Back,</span>
        
      </div>
    </div>
    <!-- /menu profile quick info -->

    <div class="clearfix"></div>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        
        <ul class="nav side-menu">
          <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a><i class="fa fa-edit"></i> Account <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="account-edit.php">Edit Profile</a></li>
              <li><a href="change-password.php">Change Password</a></li>
            </ul>
          </li>
          
          <li><a href="lead-tracking.php"><i class="fa fa-user"></i> Leads Tracking </a></li>
          <?php 
              if(Login::CheckFeaturedRights($_SESSION['DealerId']))
              {
          ?>
          <li><a><i class="fa fa-cogs"></i> Leads Generation <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="new-leads.php">New Leads</a></li>
              <li><a href="assigned-leads.php">Assigned Leads</a></li>
              <li><a href="dealers-management.php">Dealers Management</a></li>
            </ul>
          </li>


          <?php } ?>

          
          <li><a href="support.php"><i class="fa fa-support"></i> Support </a></li>
          <li><a href="logout.php"><i class="fa fa-power-off"></i>Logout </a></li>
        </ul>
      </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Home"  href="dashboard.php">
        <span class="fa fa-home" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="">
        <span >&nbsp;</span>
      </a>
       <a data-toggle="tooltip" data-placement="top" title="">
        <span >&nbsp;</span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout"  href="logout.php">
        <span class="fa fa-power-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>

<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav class="" role="navigation">
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
    </nav>
  </div>
</div>
<!-- /top navigation -->

