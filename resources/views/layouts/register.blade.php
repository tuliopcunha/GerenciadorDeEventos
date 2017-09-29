<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="{{ asset('/data/css/loginWhite.css') }}" rel="stylesheet"> 
        <link href="{{ asset('/data/css/passwordbar.css') }}" rel="stylesheet"> 
    <link rel="shortcut icon" href="{{ asset('/data/dist/img/iconedoif.ico') }}o" >
    <title>@yield('title')</title>
</head>
<body class="align">
  <div class="site__container">
      <div class="grid__container" align="center">
       <a href="{{ url('/') }}"><img src="{{ asset('/data/dist/img/iconedoif.ico') }}" align=""></a>
       <h2 class="form-signin-heading" align="center">@yield('titlesection')</h2>
       @yield('content')
   </div>
</div>
<script type="text/javascript" src="{!! asset('data/plugins/jQuery/jQuery-2.1.4.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('data/js/maskRegister.js') !!}"></script>
<script type="text/javascript" src="{!! asset('data/js/jquery.pstrength.js') !!}"></script>
</body>
</html>