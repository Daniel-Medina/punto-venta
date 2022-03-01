<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sistema de Venta</title>

    @include('layouts.theme.styles')
    

</head>
<body class="dashboard-analytics">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    @include('layouts.theme.Header')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('layouts.theme.sidebar')
        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                {{-- <div class="page-header">
                    <div class="page-title">
                        <h3>Analytics</h3>
                    </div>
                </div> --}}

                <!----<div class="row layout-top-spacing"> ---->

                    @yield('content')

                <!-----</div> ------->
            </div>

            @include('layouts.theme.fooder')
        </div>
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->

    @include('layouts.theme.scripts')

</body>
</html>