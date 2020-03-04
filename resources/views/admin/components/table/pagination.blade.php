@php
  $rowPerPage = !empty(Session::get('rowPerPage')) ? Session::get('rowPerPage') : 15;
  $rowPerPageOptions = [5, 15, 30 ,50];
@endphp
<section class="component__grid-pagination">
	<div class="row">
  	<div class="col-sm">
  		<select class="form-control input-sm grids-control-records-per-page" style="display: inline; width: 80px; margin-right: 10px">
      @foreach($rowPerPageOptions as $rppo)
			  <option value="{{ $rppo }}" @php echo ($rppo == $rowPerPage) ? "selected" : "";  @endphp>{{ $rppo }}</option>
      @endforeach
  		</select>@lang('common.record-per-page')
    </div>
  	<div class="col-sm">
      {{$data->links()}}
    </div>
    <div class="col-sm">
  		<span>
  			@lang('common.total') {{$data->total()}} @lang('common.record')
  		</span>
  	</div>
  </div>
</section>
