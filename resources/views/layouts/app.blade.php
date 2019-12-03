<!DOCTYPE html>
<html lang="en">
<head>
  <title>CodeKlass Laravel 6 AJAX CRUD</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css")}}">
</head>
<body>

@include('layouts.header')


@yield('content')

@include('layouts.footer')
</body>
<script src="{{ asset("assets/js/jquery.min.js")}}"></script>
  <script src="{{ asset("assets/js/popper.min.js")}}"></script>
  <script src="{{ asset("assets/js/bootstrap.min.js")}}"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
});
	
</script>
@yield('scripts')

</body>
</html>
