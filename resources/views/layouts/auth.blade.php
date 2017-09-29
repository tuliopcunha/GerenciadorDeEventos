<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="{{ asset('/data/css/loginWhite.css') }}" rel="stylesheet" id="css"> 
    <link rel="shortcut icon" href="{{ asset('/data/dist/img/iconedoif.ico') }}">
    <title>@yield('title')</title>
</head>
<body class="align">
  <div class="site__container">
  <div class="grid__container" align="center">
	<a href="{{ url('/') }}"><img src="{{ asset('/data/dist/img/iconedoif.ico') }}"></a>
		<h2 class="form-signin-heading" align="center">@yield('titlesection')</h2>
        @yield('content')
    </div>
    </div>

</body>
</html>



