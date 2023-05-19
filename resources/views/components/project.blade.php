<div class="dark:bg-slate-700 bg-turquoise-100 text-white rounded p-4 grid grid-cols-3 w-full">
  <div class="w-full h-32 col-span-2">
    <h1>{{$project['country']}}</h1>
    <div class="w-28">
      <img src="{{$project['image']}}" alt="Country Picture" class="rounded h-full w-full">
    </div>
  </div>
  <div class="flex flex-col justify-between">
    <div class="flex flex-col w-full">
      <div class="flex flex-row space-x-1 w-full">
        <h2>@lang('from')</h1>
        <h2>{{$project['start']}}</h2>
      </div>
      <div class="flex flex-row space-x-1 w-full">
        <h2>@lang('to')</h1>
        <h2>{{$project['end']}}</h2>
      </div>
    </div>
    <h2 :text="$project['headcount'].' '.__($project['people'])"/>
  </div>
</div>
