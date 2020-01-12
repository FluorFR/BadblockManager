    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">
            <!-- User -->
            <div class="user-box">
                <div class="user-img">
                    <img src="https://cdn.badblock.fr/head/{{ Auth::user()->name}}/48.png" alt="user-img" title="{{ Auth::user()->name}}" class="img-circle img-thumbnail img-responsive">
                    <div class="user-status offline"><i class="zmdi zmdi-dot-circle"></i></div>
                </div>
                <h5><a href="#">{{ Auth::user()->name}}</a> </h5>
                <ul class="list-inline">
                    <li>
                        <a href="#" >
                            <i class="zmdi zmdi-settings"></i>
                        </a>
                    </li>

                    <li>
                        <a class="text-custom" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            <i class="zmdi zmdi-power"></i>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
            <!-- End User -->

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <ul>
                    <li>
                        <a href="/players" class="waves-effect">
                            <i class="fa  fa-search"></i>
                            <span> Rechercher</span>
                        </a>
                    </li>






                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Left Sidebar End -->