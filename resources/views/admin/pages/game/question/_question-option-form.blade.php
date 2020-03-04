<section class="component__update-form">
  <form action="{{ route($routePrefix.'.addOption', ['gameId' => $gameId, 'id' => $obj->id] )}}"
    method="POST"
    enctype="multipart/form-data">
    @csrf

    <button type="button" class="btn btn-primary add">Add</button>
    <table class="grid-table table table-striped table-bordered table-responsive-sm">
      <thead>
        <tr>
          <th>type</th>
          <th>text</th>
          <th>is_active</th>
          <th>is_answer</th>
          <th>remove</th>
        </tr>
      </thead>
      <tbody class="options-wrapper">
      </tbody>
    </table>

    <div>
      <button class="btn btn-primary">
        <span class="action-icon">
          <i class="fas fa-save"></i> @lang('common.save')
        </span>
      </button>
    </div>
  </form>
</section>

<table style="display: none;">
  <tbody>
    <tr class="clone">
      <td><input type="text" class="form-control" id="clone-type" name="type[]" value="" /></td>
      <td><input type="text" class="form-control" id="clone-text" name="text[]" value="" /></td>
      <td><input type="text" class="form-control" id="clone-is_active" name="is_active[]" value="" /></td>
      <td><input type="text" class="form-control" id="clone-is_answer" name="is_answer[]" value="" /></td>
      <td><button type="button" class="btn btn-primary remove">Remove</button></td>
    </tr>
  </tbody>
</table>
<script>
  $(document).ready(function() {
    var initData = {!! $obj->options->toJson() !!}
    var initialValue = {
      type: 'text',
      text: '',
      is_active: 0,
      is_answer: 0,
    };
    init();

    $('.add').click(function() {
      clone(initialValue);
    });

    $('.options-wrapper').on('click', '.remove', function() {
      remove($(this));
    });

    function init() {
      initData;
      initData.forEach(function(row) {
        clone(row);
      });
    }

    function clone(data) {
      var clone = $('.clone').clone();

      clone.find('#clone-type').val(data.type);
      clone.find('#clone-text').val(data.text);
      clone.find('#clone-is_active').val(data.is_active);
      clone.find('#clone-is_answer').val(data.is_answer);
      clone.removeClass('clone');

      $('.options-wrapper').append(clone);
    }

    function remove(elem) {
      elem.parent().parent().remove();
    }
  });
</script>