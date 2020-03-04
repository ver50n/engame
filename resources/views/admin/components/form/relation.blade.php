<div class="relation-form">
	<div style="width: 50%; float: left;">
		<div>@lang('common.relation.unregistered')</div>
		<select class="form-control notregistered" multiple style="min-height: 150px;">
		</select>
    <div align="right" style="padding-right: 10%;">
			<button type="button" class="btn btn-secondary next"> @lang('common.relation.next') </button>
			<button type="button" class="btn btn-secondary moveall"> @lang('common.relation.move-all') </button>
			<button type="button" class="btn btn-secondary reset"> @lang('common.relation.reset') </button>
    </div>
	</div>
	<div style="width: 50%; float: left;">
		<div>@lang('common.relation.registered')</div>
		<form method="post" action="{{$updateRoute}}" class="regform">
			@csrf
			<select class="form-control registered" multiple name="selected[]" style="min-height: 150px;">
			</select>
      <div align="left">
				<button type="button" class="btn btn-secondary remove_registered"> @lang('common.relation.remove-selected') </button>
				<button type="button" class="btn btn-secondary clear_all"> @lang('common.relation.clear-all') </button>
				<button type="button" class="btn btn-secondary btnSaveChanges"> @lang('common.relation.save') </button>
      </div>
			<input type="hidden" name="flag" class="flag" />
		</form>
	</div>
	<div style="clear: both;"></div>
</div>

<script src="{{ asset('/js/plugins/relation.js') }}"></script>
<script>
	var options = { data: '{!! json_encode($relationData, JSON_UNESCAPED_UNICODE) !!}' }
	$(".relation-form").relation(options);
</script>
