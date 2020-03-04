@extends('admin.layouts.base-layout')
@section('content')
	@include('admin.layouts.includes.breadcrumb', ['params' => ['id' => $obj->id]])
  <h4>@lang('common.admin') @lang('common.view-page')</h4>
	<div class="grid-action-wrapper">
		<div class="grid-action">
			<a href="{{route($routePrefix.'.create')}}">
				<button class="btn btn-primary">
		      <i class="fas fa-plus"></i> @lang('common.create')
				</button>
			</a>
		</div>
		<div class="grid-action">
			<a href="{{route($routePrefix.'.update', ['id' => $obj->id])}}">
				<button class="btn btn-primary">
		      <i class="fas fa-edit"></i> @lang('common.update')
				</button>
			</a>
		</div>
		<div class="grid-action">
			<form action="{{route('helpers.activate', [
				'id' => $obj->id,
			])}}"
				id="grid-action-activation"
				method="POST"
			>
				@csrf
				<input type="hidden" name="model" value="Admin" />
			</form>
			<button class="btn btn-primary"
				onClick="document.getElementById('grid-action-activation').submit()">
			@if($obj->is_active == 0)
	      <i class="fas fa-check"></i> @lang('common.activate')
			@else
	      <i class="fas fa-times"></i> @lang('common.disactivate')
			@endif
			</button>
		</div>
	</div>
  <section class="card components__card-section-wrapper">
    <div class="card-header">
      <a data-toggle="collapse" href="#collapse-view__base-info"
        aria-expanded="true"
        aria-controls="collapse-view__base-info"
        id="view" class="d-block">
        <i class="fa fa-chevron-down pull-right"> @lang('common.base-info')</i>
      </a>
    </div>
    <div id="collapse-view__base-info" class="collapse show">
      <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-condensed">
          <tbody>
            <tr>
              <th>@lang('common.id')</th>
              <td>{{$obj->id}}</td>
            </tr>
            <tr>
              <th>@lang('common.admin_type')</th>
              <td>{{Lang::get('application-constant.YES_NO.'.App\Helpers\ApplicationConstant::ADMIN_TYPE[$obj->admin_type])}}</td>
            </tr>
            <tr>
              <th>@lang('common.name')</th>
              <td>{{$obj->name}}</td>
            </tr>
            <tr>
              <th>@lang('common.email')</th>
              <td>{{$obj->email}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>


  <section class="card components__card-section-wrapper">
    <div class="card-header">
      <a data-toggle="collapse" href="#collapse-view__status-info"
        aria-expanded="true"
        aria-controls="collapse-view__status-info"
        id="view" class="d-block">
        <i class="fa fa-chevron-down pull-right"> @lang('common.status-info')</i>
      </a>
    </div>
    <div id="collapse-view__status-info" class="collapse show">
      <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-condensed">
          <tbody>
            <tr>
              <th>@lang('common.is_active')</th>
              <td>{{Lang::get('common.'.App\Helpers\ApplicationConstant::YES_NO[$obj->is_active])}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="card components__card-section-wrapper">
    <div class="card-header">
      <a data-toggle="collapse" href="#collapse-view__log-info"
        aria-expanded="true"
        aria-controls="collapse-view__log-info"
        id="view" class="d-block">
        <i class="fa fa-chevron-down pull-right"> @lang('common.log-info')</i>
      </a>
    </div>
    <div id="collapse-view__log-info" class="collapse show">
      <div class="card-body">
        <table class="table table-bordered table-striped table-hover table-condensed">
          <tbody>
            <tr>
              <th>@lang('common.created_at')</th>
              <td>{{$obj->created_at}}</td>
            </tr>
            <tr>
              <th>@lang('common.updated_at')</th>
              <td>{{$obj->updated_at}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection
