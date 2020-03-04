<section class="component__update-form">
  <form action="{{route($routePrefix.'.edit', ['id' => $obj->id])}}"
    method="POST"
    enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label>@lang('common.name')</label>
      <input class="form-control input-sm"
        name="name"
        value="{{old('name') ?: $obj->name}}" />
      <span class="component__form__error-block">{{$errors->first('name')}}</span>
    </div>

    <div class="form-group">
      <label>@lang('common.round')</label>
      <input class="form-control input-sm"
        name="round"
        value="{{old('round') ?: $obj->round}}" />
      <span class="component__form__error-block">{{$errors->first('round')}}</span>
    </div>

    <div class="form-group">
      <label>@lang('common.description')</label>
      <textarea class="form-control input-sm"
        name="description">{{old('description') ?: $obj->description}}</textarea>
      <span class="component__form__error-block">{{$errors->first('description')}}</span>
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
