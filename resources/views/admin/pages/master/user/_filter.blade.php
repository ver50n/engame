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
            <form action='list' method="GET">
              <div class="form-group">
                <label>@lang('common.id')</label>
                <input class="form-control input-sm"
                  name="filters[id]"
                  value="{{$obj->id}}" />
              </div>
              <div class="form-group">
                <label>@lang('common.name')</label>
                <input class="form-control input-sm"
                  name="filters[name]"
                  value="{{$obj->name}}" />
              </div>
              <div class="form-group">
                <label>@lang('common.email')</label>
                <input class="form-control input-sm"
                  name="filters[email]"
                  value="{{$obj->email}}" />
              </div>
              <div>
                <button type="submit" class="btn btn-primary">
                  <span class="action-icon">
                    <i class="fas fa-filter"></i> @lang('common.filter')
                  </span>
                </button>
                <a href="{{route($routePrefix.'.list')}}">
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
