@extends('admin.layouts.base-layout')
@section('content')
	<div class="wrapper">
		<div class="card">
      <div class="card-header">
        @lang('common.info.login')
      </div>
      <div class="card-body">
				@include('admin.layouts.form.error')
        <form action="{{route('admin.authenticate')}}" method="POST">
      	  {{ csrf_field() }}
          <div class="form-group">
            <label for="email">@lang('common.email')</label>
            <input type="email" class="form-control" name="email" id="email"
							placeholder="@lang('common.email')" value="{{old('email')}}">
          </div>
          <div class="form-group">
            <label for="password">@lang('common.password')</label>
            <input type="password" name="password" class="form-control"
							id="password" placeholder="@lang('common.password')">
          </div>
          <button type="submit" class="btn btn-primary">@lang('common.info.login')</button>
        </form>
      </div>
    </div>
	</div>
@endsection
