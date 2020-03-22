@extends('admin.layouts.base-layout')
@section('content')
	@include('admin.layouts.includes.breadcrumb', [
    'params' => [
      'gameId' => $gameId
    ]
  ])
	<h4>@lang('common.question') @lang('common.list-page')</h4>

	<div class="grid-action-wrapper">
		<div class="grid-action">
			@include('admin.pages.game.question._filter', ['obj' => $obj])
		</div>
		<div class="grid-action">
			<a href="{{route($routePrefix.'.create', ['gameId' => $gameId])}}">
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
      'question' => ['sortable' => true],
      'is_active' => ['sortable' => true],
      'action' => [],
    ]
	])
    <tbody>
    @foreach($data as $row)
      <tr>
        <td>{{$row->id}}</td>
        <td>
          {!! nl2br($row->question) !!}
        </td>
        <td>{{Lang::get('application-constant.YES_NO.'.App\Helpers\ApplicationConstant::YES_NO[$row->is_active])}}</td>
        <td>
			<div class="grid-body-action__icon-wrapper">
			<a href="{{route($routePrefix.'.update', ['gameId' => $gameId, 'id' => $row->id])}}">
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
