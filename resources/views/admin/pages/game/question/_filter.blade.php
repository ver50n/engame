<section class="component__filter-form">
  <button type="button"
    class="btn btn-secondary"
    data-toggle="modal"
    data-target="#filter-popup">
    <span class="action-icon">
      <i class="fas fa-filter"></i> @lang('common.filter')
    </span>
  </button>
  <div class="modal fade" id="filter-popup"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="card">
          <div class="card-header"></div>
          <div class="card-body">
            <form action="{{ route($routePrefix.'.list', ['gameId' => $gameId]) }}" method="GET">
              <div class="form-group">
                <label>@lang('common.id')</label>
                <input class="form-control input-sm"
                  name="filters[id]"
                  value="{{$obj->id}}" />
              </div>
              <div class="form-group">
                <label>@lang('common.question')</label>
                <input class="form-control input-sm"
                  name="filters[question]"
                  value="{{$obj->question}}" />
              </div>
              <div class="form-group">
                <label>@lang('common.is_active')</label>
                <select name="filters[is_active]"
                  class="form-control input-sm">
                <option value="">-- --</option>
                @foreach(App\Helpers\ApplicationConstant::getDropdown('YES_NO') as $key => $value)
                  <option value="{{$key}}" {{ $obj->is_active === strval($key) ? 'selected' : '' }}>
                    {{$value}}
                  </option>
                @endforeach
                </select>
              </div>
              <div>
                <button type="submit" class="btn btn-primary">
                  <span class="action-icon">
                    <i class="fas fa-filter"></i> @lang('common.filter')
                  </span>
                </button>
                <a href="{{ route($routePrefix.'.list', ['gameId' => $gameId]) }}">
                  <button type="button" class="btn btn-primary reset-filter">
                    <span class="action-icon">
                      <i class="fas fa-sync-alt"></i> @lang('common.reset')
                    </span>
                  </button>
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
