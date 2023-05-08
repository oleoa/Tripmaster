<div class="dark:bg-slate-700 bg-turquoise-100 text-white rounded p-4 grid grid-cols-3 w-full">
  <div class="w-full h-32 col-span-2">
    <x-h1 :text="$project['country']"/>
    <div class="w-28">
      <img src="{{$project['image']}}" alt="Country Picture" class="rounded h-full w-full">
    </div>
  </div>
  <div class="flex flex-col justify-between">
    <div class="flex flex-col w-full">
      <div class="flex flex-row space-x-1 w-full">
        <x-h2 :text="__('from')"/>
        <x-h2 :text="$project['start']"/>
      </div>
      <div class="flex flex-row space-x-1 w-full">
        <x-h2 :text="__('to')"/>
        <x-h2 :text="$project['end']"/>
      </div>
    </div>
    <x-h2 :text="$project['headcount'].' '.__($project['people'])"/>
  </div>
</div>
