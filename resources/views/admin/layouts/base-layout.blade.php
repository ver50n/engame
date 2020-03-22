<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@lang('common.title-admin')</title>
	@include('admin.layouts.includes.asset')
	@include('admin.layouts.includes.header')
</head>

<body>
	<div id="app" class="admin-wrapper">
		@include('admin.layouts.includes.navbar')
		<div class="container-fluid body-container">
			@if (session('success'))
	      <div class="alert alert-success">
				  <strong>@lang('common.success') : </strong>@lang('common.'.session('success'))
				  <button type="button" class="close" onclick="$('.alert').hide()">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
	    @endif
			@if (session('error'))
	      <div class="alert alert-danger">
				  <strong>@lang('common.error') : </strong>@lang('common.'.session('error'))
				  <button type="button" class="close" onclick="$('.alert').hide()">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
	    @endif
		@yield('content')
		</div><br />
	</div>
</body>
</html>
