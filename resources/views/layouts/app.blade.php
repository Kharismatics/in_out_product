<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (Auth::check())
    <title>{{ Auth::user()->name }}</title>                  
    @else
    <title>{{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/app.js') }}" ></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @if (Auth::check())
                    {{ Auth::user()->name }}                    
                    @else
                    {{ config('app.name', 'Laravel') }}                        
                    @endif
                </a>
                @if (Auth::check())
                <div class="navbar-brand">
                    <select class="" id="SelectLang">
                        <option value="en" {{ ( App::getLocale() == 'en') ? 'selected':'' }}>EN</option>
                        <option value="id" {{ ( App::getLocale() == 'id') ? 'selected':'' }}>ID</option>
                    </select>
                </div>
                @endif
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="navbar-brand dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Master <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/peoples') }}">
                                    @lang('text.supplier')/@lang('text.customer')
                                </a>
                                <a class="dropdown-item" href="{{ url('/category') }}">
                                    @lang('text.category')
                                </a>
                                <a class="dropdown-item" href="{{ url('/products') }}">
                                    @lang('text.product')
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="navbar-brand dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @lang('text.transaction') <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/transactions') }}">
                                    @lang('text.purchasing') & @lang('text.sales')
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="navbar-brand dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @lang('text.report') <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/daily_report') }}">
                                    @lang('text.daily')
                                </a>
                                <a class="dropdown-item" href="{{ url('/monthly_report') }}">
                                    @lang('text.monthly')
                                </a>
                            </div>
                        </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @lang('text.account') <i class="fas fa-user"></i><span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Setting') }} <i class="fas fa-cog"></i>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }} <i class="fas fa-arrow-left"></i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        $(document).ready(function() {
            // datatable
            $('.table tfoot th').each( function () {
                var title = $(this).text();
                if (title !=="#" && title !=="@lang('text.action')"){
                    $(this).html( 
                    '<input class="text-warning col-lg-12 col-md-12" type="text" placeholder="'+title+'">'
                    );
                }
            } );
            var $TABLE = $('.table').DataTable( {
                @if (App::isLocale('id'))
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                    },
                @endif
                // dom: 'Bfrtip',
                dom:
                // "<'row'<'col-sm-9'B><'col-sm-3 text-left'l>>"+
                "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 text-right'B>>" +
				'<t>'+
				"<'row'<'col-sm-4'i><'col-sm-8'p>>",
                // buttons: [
                //     'copy', 
                //     'csv', 
                //     'excel', 
                //     'pdf', 
                //     'print'
                // ]
                buttons: [
					{ extend: "copy", exportOptions: { columns: 'th:not(:last-child)' },  text: '<i class="fas fa-copy"></i>', className: 'btn btn-secondary',titleAttr: 'Copy'},
					{ extend: "excel", exportOptions: { columns: 'th:not(:last-child)' },   text: '<i class="fas fa-file-excel"></i>', className: 'btn btn-success',titleAttr: 'Export to Excel'},
					{ extend: "pdf", exportOptions: { columns: 'th:not(:last-child)' },   text: '<i class="fas fa-file-pdf"></i>', className: 'btn btn-danger',titleAttr: 'Export to pdf'},
					{ extend: "print", exportOptions: { columns: 'th:not(:last-child)' },   text: '<i class="fas fa-print"></i>', className: 'btn btn-secondary',titleAttr: 'Print'}
				]
            } );           
           if($TABLE.columns().eq(0)) {
               $TABLE.columns().eq(0).each( function ( colIdx ) {
                   $( 'input', 'th:nth-child('+(colIdx+1)+')' ).on( 'keyup change', function() {
                           $TABLE
                               .column( colIdx )
                               .search( this.value )
                               .draw();
                   });
               });  
           }              
            // datatable

        } );
        // Location
        $('#SelectLang').change(function (e) { 
            var url = '{{ url('/lang') }}\/'+$(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect                
            }
            return false;                  
        });
        // Location
        $('.delete-data').click(function (e) {     
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementsByClassName('delete-form').submit();
                }
            });
        });
    </script>
</body>
</html>