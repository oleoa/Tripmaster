<div class="dark:bg-slate-700 bg-turquoise-100 text-white rounded p-4 grid grid-cols-2">
  <div class="w-full space-y-4">
    <x-h1 :text="$project['country']"/>
    <div class="flex flex-row space-x-2">
      <h2>{{$project['start']}}</h2><span>-</span><h2>{{$project['end']}}</h2>
    </div>
    <x-h2 :text="$project['headcount'].' '.__($project['people'])"/>
  </div>
  <div class="pl-2">
    <img src="{{$project['image']}}" alt="Country Picture" class="rounded h-full w-full">
  </div>
</div>
