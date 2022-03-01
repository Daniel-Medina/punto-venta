<link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.ico')}}"/>
<link href="{{asset('assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('assets/js/loader.js')}}"></script>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/structure.css')}}" rel="stylesheet" type="text/css" class="structure" />
<!-- END GLOBAL MANDATORY STYLES -->

<link rel="stylesheet" href="{{asset('plugins/fontawesome/css/fontawesome.css')}}">


<link rel="stylesheet" href="{{asset('assets/css/elements/avatar.css')}}">

<link rel="stylesheet" href="{{asset('plugins/sweetalerts/sweetalert.css')}}">
<link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/css/widgets/modules-widgets.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/forms/theme-checkbox-radio.css')}}">

<style>
    aside{
        display: none!important;
    }

    .page-items-active .page-link{
        z-index: 3;
        color: #fff;
        background-color: #3b3f5c;
        border-color: #3b3f5c; 
    }
    
    @media (max-width: 480px)
    {
        .mtmobile {
            margin-bottom: 20px!important;
        }
        .mbmobile {
            margin-bottom: 10px!important;
        }
        .hideonsm {
            display: none!important;
        }
        .inblock {
            display: block;
        }
    }

    /* SideBAr color de fondo */
    .sidebar-theme #compactSidebar {
        background: #191e3a!important;
    }

    /* Color del icono de la barra de navegacion */
    .header-container .sidebarCollapse {
        color: #3b3f5c!important;
    }

    /* Barra de Busqueda */
    .navbar .navbar-item .nav-item form.form-inline input.search-form-control {
        font-size: 15px;
        background-color: #3b3f5c!important;
        padding-right: 40px;
        padding-top: 12px;
        border: none;
        color: #fff;
        box-shadow: none;
        border-radius: 30px;
    }


</style>
<style>
    .activo {
        background: midnightblue !important;
    }
</style>

@livewireStyles

{{-- <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="{{asset('plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" class="dashboard-analytics" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES --> --}}

<link rel="stylesheet" href="{{asset('assets/css/apps/scrumboard.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/css/apps/notes.css')}}"> --}}

<!-----Select 2 --------->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

{{-- <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}" --}}
<link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr-dark.css')}}" />