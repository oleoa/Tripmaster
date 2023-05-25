<h1>{{$stay['title']}}</h1>
<h1>{{$stay['capacity']}}</h1>
<h1>{{$stay['price']}}</h1>
<div class="flex items-center justify-end space-x-4">
  <a class="px-6 py-4 bg-green-600 hover:bg-green-500 hover:no-underline rounded" href="">@lang('View')</a>
  <a class="px-6 py-4 bg-blue-600 hover:bg-blue-500 hover:no-underline rounded" href="">@lang('Edit')</a>
  <a class="px-6 py-4 bg-red-600 hover:bg-red-500 hover:no-underline rounded" href="{{route('my.delete.stay', ['id' => $stay['id']])}}">@lang('Delete')</a>
</div>
