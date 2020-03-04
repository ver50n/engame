@extends('admin.layouts.base-layout')
@section('content')
	@include('admin.layouts.includes.breadcrumb', ['params' => []])
	<h4>@lang('common.admin') @lang('common.list-page')</h4>

	<div class="grid-action-wrapper">
		<div class="grid-action">
			@include('admin.pages.master.admin._filter', ['obj' => $obj])
		</div>
		<div class="grid-action">
			<a href="{{route($routePrefix.'.create')}}">
				<button class="btn btn-primary">
		      <i class="fas fa-plus"></i> @lang('common.create')
				</button>
			</a>
		</div>
		<div class="grid-action">
			<form action="{{route('helpers.export')}}" type="POST">
				<input type="hidden" name="model" value="Admin" />
				<button class="btn btn-primary">
		      <i class="fas fa-file-export"></i> @lang('common.export')
				</button>
			</form>
		</div>
	</div>
  <table class="grid-table table table-striped table-bordered table-responsive-sm">
  @include('admin.components.table.header',[
		'headers' => [
      'id' => ['sortable' => true],
      'admin_type' => ['sortable' => true],
      'name' => ['sortable' => true],
      'email' => ['sortable' => true],
      'is_active' => ['sortable' => true],
      'created_at' => ['sortable' => true],
			'action' => ['sortable' => false]
    ]
	])
    <tbody>
    @foreach($data as $row)
      <tr>
        <td>{{$row->id}}</td>
        <td>{{Lang::get('application-constant.ADMIN_TYPE.'.App\Helpers\ApplicationConstant::ADMIN_TYPE[$row->admin_type])}}</td>
        <td>{{$row->name}}</td>
        <td>{{$row->email}}</td>
        <td>{{Lang::get('application-constant.YES_NO.'.App\Helpers\ApplicationConstant::YES_NO[$row->is_active])}}</td>
        <td>{{$row->created_at}}</td>
        <td>
					<div class="grid-body-action__icon-wrapper">
			      <a href="{{route($routePrefix.'.view', ['id' => $row->id])}}">
			        <span class="action-icon">
			          <i class="icon fas fa-eye" title="view"></i>
			        </span>
			      </a>
					</div>
					<div class="grid-body-action__icon-wrapper">
			      <a href="{{route($routePrefix.'.update', ['id' => $row->id])}}">
			        <span class="action-icon">
			          <i class="icon fas fa-edit" title="edit"></i>
			        </span>
			      </a>
					</div>
					<div class="grid-body-action__icon-wrapper">
			      <form class="form-grid-delete"
							id="form-grid-delete"
							action="{{route($routePrefix.'.delete', ['id' => $row->id])}}"
							method="POST"
							style="display: none;">
	          	@csrf
			      </form>
						<a href="#" class="grid-delete" onClick="document.getElementById('form-grid-delete').submit()">
							<span class="action-icon">
								<i class="icon fas fa-trash" title="delete"></i>
							</span>
						</a>
					</div>
				</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  @include('admin.components.table.pagination', ['data' => $data])
@endsection
