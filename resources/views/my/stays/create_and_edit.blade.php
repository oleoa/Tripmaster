@extends('layouts.main')
@section('body')
<div class="p-4">
  <div class="flex flex-col items-center justify-center p-4 space-y-4 border-2 rounded">
    <div class="relative w-full flex justify-center">
      <div class="absolute right-0 top-0 py-8 px-4">
        <a href="{{route('my.list.stays')}}" class="btn">@lang('List Stay')</a>
      </div>
      <h1 class="py-6">@lang($page_title)</h1>
    </div>
    <form action="{{$form_route}}" method="POST" enctype="multipart/form-data" class="grid grid-cols-3 gap-4 w-full">
      @csrf
      @if($editing_case) @method('PUT') @endif
      <input type="hidden" value="{{$owner}}" name="owner">

      <div>
        <h2>@lang('Title')</h2>
        <input type="text" name="title" value="{{$editing_case ? $stay['title'] : null}}"/>
      </div>
      <div class="col-span-2">
        <h2>@lang('Description')</h2>
        <textarea name="description" class="bg-slate-600 rounded w-full text-white p-2">{{$editing_case ? $stay['description'] : null}}</textarea>
      </div>

      <div>
        <h2>@lang('Capacity')</h2>
        <input type="number" name="capacity" value="{{$editing_case ? $stay['capacity'] : null}}"/>
      </div>
      <div>
        <h2>@lang('Bedrooms')</h2>
        <input type="number" name="bedrooms" value="{{$editing_case ? $stay['bedrooms'] : null}}"/>
      </div>

      <div>
        <h2>@lang('Price per month')</h2>
        <input type="number" name="price" value="{{$editing_case ? $stay['price'] : null}}"/>
      </div>

      <div>
        <h2>@lang('Country')</h2>
        <input type="text" name="country" value="{{$editing_case ? $stay['country'] : null}}"/>
      </div>
      <div>
        <h2>@lang('City')</h2>
        <input type="text" name="city" value="{{$editing_case ? $stay['city'] : null}}"/>
      </div>
      @if(!$editing_case)
        <div>
          <h2>@lang('Images')</h2>
          <input type="file" name="images[]" placeholder="Images" multiple="TRUE"/>
        </div>
      @endif
      <div class="col-span-3">
        <input type="submit" value="@lang($submit_button)" class="hover:bg-slate-500"/>
      </div>
    </form>
  </div>
</div>
@endsection