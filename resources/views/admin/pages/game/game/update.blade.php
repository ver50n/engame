@extends('admin.layouts.base-layout')
@section('content')
	@include('admin.layouts.includes.breadcrumb', ['params' => ['id' => $obj->id]])
  <h4>@lang('common.game') @lang('common.update-page')</h4>
  <div class="grid-action-wrapper">
		<div class="grid-action">
			<a href="{{route('admin.game.game.create')}}">
				<button class="btn btn-primary">
		      <i class="fas fa-plus"></i> Create</button>
			</a>
		</div>
		<div class="grid-action">
      <form action="{{route('helpers.activate', [
          'id' => $obj->id
        ])}}" method="POST">
        @csrf
				<input type="hidden" name="model" value="Game">
				<button class="btn btn-primary">
		      <i class="fas fa-thumb-up"></i> 
          {{ ($obj->is_active) ? 'Disactivate' : 'Activate' }}
        </button>
			</form>
		</div>
		<div class="grid-action">
			<a href="{{route('admin.game.question.list', ['gameId' => $obj->id])}}">
				<button class="btn btn-primary">
		      <i class="fas fa-question"></i> @lang('common.question')
				</button>
			</a>
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
        @include('admin.pages.game.game._update-form')
      </div>
    </div>
  </section>
@endsection
