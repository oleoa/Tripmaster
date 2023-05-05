@if ($errors->any())
  <div class="alert alert-danger p-4">
    <ul class="text-white space-y-4">
      @foreach ($errors->all() as $error)
        <li class="text-2xl">@lang($error)</li>
      @endforeach
    </ul>
  </div>
@endif