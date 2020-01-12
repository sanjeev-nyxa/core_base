<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet"
          type="text/css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{env('APP_NAME')}}</title>

    <!-- Styles -->
    <link href="{{ mix('admin/css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script src="https://use.fontawesome.com/273511292e.js"></script>
</head>
<body>
<div id="zix-admin"></div>

<!-- Scripts -->
@if(env('USE_SOCKET_SERVER'))
    <script src="//{{ Request::getHost() }}:8080/socket.io/socket.io.js"></script>
@endif
<script src="{{ mix('admin/js/app.js') }}"></script>
</body>
</html>
