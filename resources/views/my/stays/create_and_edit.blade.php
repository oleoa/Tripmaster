@extends('layouts.main')
@section('body')
<main>
  <div class="relative all-center">
    <div class="absolute right-0">
      <a href="{{route('my.list.stays')}}" class="btn-okay">@lang('List Stay')</a>
    </div>
    <h1 class="py-6">@lang($page_title)</h1>
  </div>

  <form action="{{$form_route}}" method="POST" enctype="multipart/form-data" class="grid grid-cols-3 gap-4 w-full">
    @csrf
    @if($editing_case) @method('PUT') @endif
    <input type="hidden" value="{{$owner}}" name="owner">

    <div>
      <h2>@lang('Title')</h2>
      <input type="text" name="title" value="{{$editing_case ? $stay['title'] : old('title') }}"/>
    </div>
    <div class="col-span-2">
      <h2>@lang('Description')</h2>
      <textarea name="description" class="bg-slate-600 rounded w-full text-white p-2">{{$editing_case ? $stay['description'] : old('description')}}</textarea>
    </div>

    <div>
      <h2>@lang('Capacity')</h2>
      <input type="number" name="capacity" value="{{$editing_case ? $stay['capacity'] : old('capacity')}}"/>
    </div>
    <div>
      <h2>@lang('Bedrooms')</h2>
      <input type="number" name="bedrooms" value="{{$editing_case ? $stay['bedrooms'] : old('bedrooms')}}"/>
    </div>

    <div>
      <h2>@lang('Price per month')</h2>
      <input type="number" name="price" value="{{$editing_case ? $stay['price'] : old('price')}}"/>
    </div>

    <div>
      <h2>@lang('Country')</h2>
      <select name="country" class="p-4">
        @foreach($possible_countries as $country)
          <option value="{{$country}}" {{$editing_case && ($stay['country'] == $country) || $country == 'France' ? 'selected' : ''}}>{{$country}}</option>
        @endforeach
      </select>
    </div>

    <div>
      <h2>@lang('City')</h2>
      <input type="text" name="city" value="{{$editing_case ? $stay['city'] : old('city')}}"/>
    </div>

    @if(!$editing_case)
      <div>
        <h2>@lang('Images')</h2>
        <input type="file" name="images[]" placeholder="Images" multiple="TRUE"/>
      </div>
    @endif

    <div class="col-span-3">
      <input type="submit" value="@lang($submit_button)" class="btn-good"/>
    </div>
  </form>
</main>
@endsection
