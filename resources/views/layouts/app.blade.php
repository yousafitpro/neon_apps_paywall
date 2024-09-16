<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .mcardbody{
            padding-left:20px;
            padding-top:10px;
            padding-bottom:10px;
        }
        .mytop .light_blue{
            border-left: solid 2px lightblue;
        }
        .mytop .light_red{
            border-left: solid 2px rgb(139, 73, 73);
        }
        .mytop .light_purple{
            border-left: solid 2px purple;
        }
        .dark-modal {
    background-color: #343a40; /* Dark background */
    color: #ffffff; /* Light text */
    border: none;
}

.dark-modal .modal-header {
    border-bottom: 1px solid #444;
}

.dark-modal .modal-footer {
    border-top: 1px solid #444;
}

.dark-modal .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.dark-modal .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.dark-modal .close span {
    color: #ffffff;
}
.dark-input {
    background-color: #343a40; /* Dark background */
    color: #ffffff; /* Light text */
    border: 1px solid #444; /* Border color */
}

.dark-input:focus {
    background-color: #495057; /* Darker background on focus */
    color: #ffffff;
    border-color: #007bff; /* Blue border on focus */
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Light blue shadow on focus */
}

/* Placeholder text color */
.dark-input::placeholder {
    color: #cccccc;
}
            .btn_back{
        color: white !important;
        font-size: 14px;
        border-radius: 10px;
        background-color: #25272A;
        padding: 10px;
        margin-right: 20px;
        padding-left: 20px;
        padding-right: 20px;
    }
    .table_card{
        background-color: #25272A;
    }
    .table_card td,th{
        color: white !important;
    }
    .table_card .dataTables_info{
        color: white !important;
    }
    .table_card .dataTables_length{
        color: white !important;
    }
    .table_card select[name="yourDataTable_length"] {
        color: white !important;
    }
    .table_card #yourDataTable_filter{
        color: white !important;
    }
    .table_card td{
        background-color: #25272A;
    }
    .mcard{
        margin-top: 10px;
        background-color: #25272A;
        width: 100%;
        min-height: 100px;
        border-radius: 20px;
        padding: 8px;
    }
    .mcard label{
        color: #809FB8
    }
    .mcard small{
        color: white
    }
    .navbar-nav li a{
        color: white
    }
    .select2-container--default .select2-selection--single {
    background-color: #333; /* Dark background */
    color: #fff; /* White text */
    border: 1px solid #444; /* Slightly lighter border */
}

/* Main select container */
.select2-container--default .select2-selection--multiple {
    background-color: #333 !important; /* Dark background for the select box */
    color: #fff !important; /* White text */
    border: 1px solid #444 !important; /* Dark border */
}

/* Selected items in the select box */
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    color: #fff !important; /* White text */
    background-color: #333 !important; /* Dark background */
}

/* Search field */
.select2-container--default .select2-search--inline .select2-search__field {
    background-color: #333 !important; /* Dark background */
    color: #fff !important; /* White text */
    border: 1px solid #444 !important; /* Dark border */
}

/* Arrow and clear button */
.select2-container--default .select2-selection--multiple .select2-selection__arrow,
.select2-container--default .select2-selection--multiple .select2-selection__clear {
    background: #444 !important; /* Darker background */
}

/* Dropdown styling */
.select2-container--default .select2-dropdown {
    background-color: #333 !important; /* Dark background */
    border: 1px solid #444 !important; /* Dark border */
}

/* Options in the dropdown */
.select2-container--default .select2-results__option {
    background-color: #333 !important; /* Dark background */
    color: #fff !important; /* White text */
}

/* Highlighted option */
.select2-container--default .select2-results__option--highlighted {
    background-color: #555 !important; /* Highlighted background */
    color: #fff !important; /* White text */
}
        </style>
</head>
<body class="bg-black" style="background-color: black">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   Data Platform
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif


                        @else
                            <li class="nav-item dropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                 {{ __('Logout') }}
                             </a>
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if (session('message'))
            <script>
             alert("{{session('message')}}")
            </script>
        @endif
            @yield('content')
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>




    $(document).ready(function() {
        var clipboard = new ClipboardJS('.copy-icon');

clipboard.on('success', function(e) {
    // Optional: Show a message or feedback when the text is copied
    alert('Copied to clipboard!');
    e.clearSelection();
});

clipboard.on('error', function(e) {
    // Optional: Show a message or feedback if there was an error
    alert('Failed to copy.');
});
    $('.js-example-basic-single').select2({'width':'100%'});
});
    function redirect_me(url)
    {
        window.location.href=url;
    }
    </script>
</body>
</html>
