<div class="bg-slate-600 pb-4 px-3 rounded">
  <h1 class="text-center p-4">July</h1>
  <div class="grid grid-cols-10 gap-1">
    @foreach (range(1, 30) as $day)
      <div class="bg-white rounded flex items-center justify-center">
        {{$day}}
      </div>
    @endforeach
  </div>
</div>
