<section class="component__update-form">
  <form action="{{route($routePrefix.'.edit', ['id' => $obj->id])}}"
    method="POST"
    enctype="multipart/form-data"
    >
    @csrf
    <div class="form-group">
      <label>@lang('common.name')</label>
      <input class="form-control input-sm"
        name="name"
        value="{{old('name') ? old('name') : $obj->name}}" />

      <span class="component__form__error-block">{{$errors->first('name')}}</span>
    </div>
    <div class="form-group">
      <label>@lang('common.email')</label>
      <input class="form-control input-sm"
        name="email"
        value="{{old('email') ? old('email') : $obj->email}}" />

      <span class="component__form__error-block">{{$errors->first('email')}}</span>
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
