<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>GIA</title>

    <!-- Favicons -->
    <link href="/assets/img/logo.svg" rel="icon">
    <link href="/assets/img/logo.svg" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">


    <!-- Variables CSS Files. Uncomment your preferred color scheme -->
    <link href="/assets/css/variables.css?ver=<?= filemtime('assets/css/variables.css') ?>" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="/assets/css/main.css?ver=<?= filemtime('assets/css/main.css') ?>" rel="stylesheet">
    <link href="/assets/css/style.css?ver=<?= filemtime('assets/css/style.css') ?>" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    
    @if(!Route::is('login')) 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/sidebar/css/style.css">
    @endif


</head>

<body class="@if(Route::is('login')) bg-dark @endif">

    @if(!Route::is('login')) 
        <div class="d-flex align-items-stretch">

            @include('template.partials.sidebar')

            <!-- Page Content  -->
            <div id="content" class="p-4 p-md-5 pt-5">
                @yield('container')
            </div>
        </div>
    @else
        <main class="" id="main">
            <div class="container-fluid">
                @yield('container')
            </div>
        </main>
    
    @endif

    <!-- Vendor JS Files -->
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="/assets/js/main.js"></script>




    
</body>


<style>
    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }

</style>



</html>
