  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Events</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="events.php">
              <i class="bi bi-circle"></i><span>Add Event</span>
            </a>
          </li>
        </ul>
      </li><!-- End Events Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#members-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-add"></i><span>Members</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="members-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="members.php">
              <i class="bi bi-circle"></i><span>Manage Members</span>
            </a>
          </li>
        </ul>
      </li><!-- End Members Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#pastors-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-plus-square"></i><span>Pastors</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pastors-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="pastors.php">
              <i class="bi bi-circle"></i><span>Manage Pastors</span>
            </a>
          </li>
        </ul>
      </li><!-- End Pastors Nav -->
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="attendance.php">
          <i class="bi bi-envelope"></i>
          <span>Attendance history</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li>


    </ul>

  </aside><!-- End Sidebar-->
