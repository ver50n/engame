@extends('admin.layouts.base-layout')
@section('content')
	@include('admin.layouts.includes.breadcrumb', ['params' => ['id' => $obj->id]])
  <h4>@lang('common.user') @lang('common.update-page')</h4>

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
        @include('admin.pages.master.user._update-form')
      </div>
    </div>
  </section>
@endsection
