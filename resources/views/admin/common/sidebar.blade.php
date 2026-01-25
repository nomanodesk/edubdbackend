<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{asset('admin/images/faces/face1.jpg')}}" alt="profile">
          
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->shortname }}</span>
       
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{url('/home')}}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('institute_classes.index')}}">
        <span class="menu-title">Class Manager</span>
        <i class="mdi mdi-school menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('students.index')}}">
        <span class="menu-title">Student Manager</span>
        <i class="mdi mdi-account-key menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('notice_boards.index')}}">
        <span class="menu-title">Notice Board Manager</span>
        <i class="mdi mdi-file-document-box menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <span class="menu-title">Institue Profile Manager</span>
        <i class="mdi mdi-office menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('sms.report.monthly', ['month' => now()->format('Y-m')]) }}"style="text-decoration:none">
        <span class="menu-title">SMS History</span>
        <i class="mdi mdi-office menu-icon"></i>
      </a>
    </li>
    <a >
    <li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="menu-title">Log Out</span>
        <i class="mdi mdi-logout menu-icon"></i>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
    </li>

  </ul>
</nav>