<!doctype html>
<html trans="en">
    
@include('partials.head-css')

<body>

    <div id="layout-wrapper">

        @include('partials.topbar')

        @include('partials.sidebar')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @yield('container')
                    
                </div> 
            </div>
        
        @include('partials.footer')

        </div>

    </div>

    @include('partials.right-sidebar')

    @include('partials.vendor-scripts')

</body>

</html>