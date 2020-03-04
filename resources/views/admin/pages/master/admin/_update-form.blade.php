<section class="component__update-form">
  <form action="{{route($routePrefix.'.edit', ['id' => $obj->id])}}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>@lang('common.name')</label>
      <input class="form-control input-sm"
        name="name"
        value="{{old('name') ? old('name') : $obj->name}}" />

      <span class="component__form__error-block">{{$errors->first('name')}}</span>
    </div>
    <div class="form-group">
      <label>@lang('common.admin_type')</label>
      @php
        $value = old('admin_type') ? old('admin_type') : $obj->admin_type;
      @endphp
      <select name="admin_type"
        class="form-control input-sm">
      @foreach(App\Helpers\ApplicationConstant::ADMIN_TYPE as $key => $value)
        <option value="{{$key}}" {{ $value == $key ? 'selected' : '' }}>
          @lang('application-constant.ADMIN_TYPE.'.$value)
        </option>
      @endforeach
      </select>
    <span class="component__form__error-block">{{$errors->first('admin_type')}}</span>
    </div>
    <div class="form-group">
      <label>@lang('common.email')</label>
      <input class="form-control input-sm"
        name="email"
        value="{{old('email') ? old('email') : $obj->email}}" />

      <span class="component__form__error-block">{{$errors->first('email')}}</span>
    </div>
    <div class="form-group">
      <label>@lang('common.password')</label>
      <input class="form-control input-sm"
        type="password"
        name="password"
        value="{{old('password') ? old('password') : $obj->password}}" />

      <span class="component__form__error-block">{{$errors->first('password')}}</span>
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
