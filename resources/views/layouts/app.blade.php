<!DOCTYPE html>
<html>
    @include('layouts.head')

    <body class="fixed-left">
    @if(Auth::check())
        @include('layouts.top')
    @endif


    @yield('header')
    <br>
    @if(Auth::check())
        <div class="wrapper">
            <div class="container-fluid">
                @include('layouts.notif')
                <div class="container-fluid">
                  @yield('content')
                </div>
            </div>
        </div>
    @else
          @yield('content')
    @endif

    <script>
        var resizefunc = [];
    </script>

    @include('layouts.script')

    @yield('before_scripts')



    <script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
    <script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>

    @yield('after_scripts')


    <!-- page script -->
    <script type="text/javascript">
        /* Store sidebar state */
        $('.sidebar-toggle').click(function(event) {
            event.preventDefault();
            if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
                sessionStorage.setItem('sidebar-toggle-collapsed', '');
            } else {
                sessionStorage.setItem('sidebar-toggle-collapsed', '1');
            }
        });
        // To make Pace works on Ajax calls
        $(document).ajaxStart(function() { Pace.restart(); });

        // Ajax calls should always have the CSRF token attached to them, otherwise they won't work
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Set active state on menu element
        var current_url = "{{ Request::fullUrl() }}";
        var full_url = current_url+location.search;
        var $navLinks = $("ul.sidebar-menu li a");
        // First look for an exact match including the search string
        var $curentPageLink = $navLinks.filter(
            function() { return $(this).attr('href') === full_url; }
        );
        // If not found, look for the link that starts with the url
        if(!$curentPageLink.length > 0){
            $curentPageLink = $navLinks.filter(
                function() { return $(this).attr('href').startsWith(current_url) || current_url.startsWith($(this).attr('href')); }
            );
        }

        $curentPageLink.parents('li').addClass('active');
                {{-- Enable deep link to tab --}}
        var activeTab = $('[href="' + location.hash.replace("#", "#tab_") + '"]');
        location.hash && activeTab && activeTab.tab('show');
        $('.nav-tabs a').on('shown.bs.tab', function (e) {
            location.hash = e.target.hash.replace("#tab_", "#");
        });
    </script>


    </body>
</html>
