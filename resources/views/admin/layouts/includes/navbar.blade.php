<nav class="navbar navbar-light bg-light navbar-expand-md">
	<div class="navbar-brand-wrapper">
		<a class="navbar-brand" href="{{ route('admin.login') }}">
			<img src="http://www.marathonartists.com/wp-content/uploads/2017/09/dummy-logo.png" width="200" height="40"
				class="d-inline-block align-top" alt="">
		</a>
	</div>
	<button class="navbar-toggler" type="button" data-toggle="collapse"
		data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
	  aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		@if(Auth::guard('admin')->check())
		<ul class="navbar-nav">
			@include('admin.layouts.includes.menus')
		</ul>
		@endif
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				@php
				$languages = \App\Helpers\ApplicationConstant::LANGUAGE;
				$selected = Session::get('locale');
				@endphp
				<select class="form-control form-control-sm navbar-change-locale" style="margin-top: 3px;">
					@foreach($languages as $key => $language)
				  	<option value="{{$key}}" {{($selected === $key) ? 'selected' : ''}}>@lang('application-constant.LANGUAGE.'.$language)</option>
					@endforeach
				</select>
			</li>
			@if(Auth::guard('admin')->check())
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
					<span style="font-size: 16px;">
						<i class="fas fa-cogs"></i>
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						<span style="font-size: 16px;">
        			<i class="fas fa-power-off"></i>
          	</span>
					</a>
					<form id="logout-form" action="{{ route('admin.logout')  }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</div>
			</li>
			@endif
		</ul>
	</div>
</nav>
