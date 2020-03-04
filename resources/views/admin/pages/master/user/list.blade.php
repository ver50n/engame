@extends('admin.layouts.base-layout')
@section('content')
	@include('admin.layouts.includes.breadcrumb', ['params' => []])
	<h4>@lang('common.user') @lang('common.list-page')</h4>

	<div class="grid-action-wrapper">
		<div class="grid-action">
			@include('admin.pages.master.user._filter', ['obj' => $obj])
		</div>
		<div class="grid-action">
			<a href="{{route($routePrefix.'.create')}}">
				<button class="btn btn-primary">
		      <i class="fas fa-plus"></i> @lang('common.create')
				</button>
			</a>
		</div>
	</div>
  <table class="grid-table table table-striped table-bordered table-responsive-sm">
  @include('admin.components.table.header',[
		'headers' => [
      'id' => ['sortable' => true],
      'name' => ['sortable' => true],
      'email' => ['sortable' => true],
			'action' => ['sortable' => false]
    ]
	])
    <tbody>
    @foreach($data as $row)
      <tr>
        <td>{{$row->id}}</td>
        <td>{{$row->name}}</td>
        <td>{{$row->email}}</td>
        <td>
			<div class="grid-body-action__icon-wrapper">
				<a href="{{route($routePrefix.'.update', ['id' => $row->id])}}">
			        <span class="action-icon">
			          <i class="icon fas fa-edit" title="edit"></i>
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
