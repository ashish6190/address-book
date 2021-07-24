<!DOCTYPE html>
<html lang="en" dir="">
    <head>
       @include('backend.partials.address.head')
       @yield('style')
    </head>
    <body>
  <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <!-- <div class='loadscreen' id="preloader">
            <div class="loader spinner-bubble spinner-bubble-primary"></div>
        </div> -->
            
            @include('backend.partials.address.nav')

            <div class="app-main">

                @include('backend.partials.address.sidebar')
            
                @yield('content')

           </div>

        @include('backend.partials.address.script')
        @yield('script')
        
        </div>
            
    </body>

</html>
