<div class="dark:bg-slate-700 bg-turquoise-100 text-white rounded p-4 grid grid-cols-2">
  <div class="w-96 space-y-4">
    <x-h1 :text="$project['country']"/>
    <div class="flex flex-row space-x-4">
      <h2>{{$project['start']}}</h2><span>-</span><h2>{{$project['end']}}</h2>
    </div>
    <x-h2 :text="$project['headcount'].' '.__('people')"/>
  </div>
  <div class="flex items-end justify-end">
    <img src="{{$project['image']}}" alt="Country Picture" class="rounded h-full w-full">
  </div>
</div>
