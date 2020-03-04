@if($errors->any())
  <div class="alert alert-danger">
    <h4 class="alert-heading">Error!</h4>
    <ul>
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
  </div>
@endif
