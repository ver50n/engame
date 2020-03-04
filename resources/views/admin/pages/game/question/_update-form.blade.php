<section class="component__update-form">
  <form action="{{ route($routePrefix.'.edit', ['gameId' => $gameId, 'id' => $obj->id] )}}"
    method="POST"
    enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label>@lang('common.question')</label>
      <textarea class="form-control input-sm"
        name="question">{{old('question') ?: $obj->question}}</textarea>
      <span class="component__form__error-block">{{$errors->first('question')}}</span>
    </div>

    <div>
      <button type="submit" class="btn btn-primary">
        <span class="action-icon">
          <i class="fas fa-save"></i> @lang('common.save')
        </span>
      </button>
    </div>
  </form>
</section>
