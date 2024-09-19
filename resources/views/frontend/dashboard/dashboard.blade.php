<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Askbootstrap">
  <meta name="author" content="Askbootstrap">
  <title>User Dashboard - Online Food Ordering Website</title>
  <!-- Favicon Icon -->
  <link rel="icon" type="image/png" href="{{ asset('frontend/img/favicon.png') }}">
  <!-- Bootstrap core CSS-->
  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome-->
  <link href="{{ asset('frontend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
  <!-- Font Awesome-->
  <link href="{{ asset('frontend/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
  <!-- Select2 CSS-->
  <link href="{{ asset('frontend/vendor/select2/css/select2.min.css') }}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ asset('frontend/css/osahan.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.theme.css') }}">

</head>

<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

  @include('frontend.dashboard.body.header')

  @yield('dashboard')

  @include('frontend.dashboard.body.footer')

</body>

</html>