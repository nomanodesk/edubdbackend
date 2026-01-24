 <!-- partial:partials/_navbar.html -->
 <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
 <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
       
       <a class="navbar-brand brand-logo-mini" href="index.html"> <img src="{{asset('admin/images/logo-mini.svg')}}" alt="logo"></a>
       <a class="navbar-brand brand-logo" href="index.html"> <img src="{{asset('admin/images/logo.png')}}" alt="logo"></a>
     </div>
    
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          
          <ul class="navbar-nav navbar-nav-right">
          <div class="nav-profile-text">
                  <p class="mb-1 text-black">Dashboard For:  
                  @auth  
                  {{Auth::user()->Institution->instituteName}}
                  @endauth
                </p>
                </div>
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
         
            <li class="nav-item nav-logout d-none d-lg-block">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-power"></i>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
            </li>
        
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>