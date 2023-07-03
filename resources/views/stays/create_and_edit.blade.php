@extends('layouts.main')
@section('body')
<main>

  <div class="relative all-center">
    <div class="absolute right-0">
      <a href="{{route('stays.list')}}" class="btn okay">@lang('List Stay')</a>
    </div>
    <h1 class="py-6">@lang($page_title)</h1>
  </div>

  <form action="{{$form_route}}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">

    @csrf
    @if($editing_case) @method('PUT') @endif
    <input type="hidden" value="{{$owner}}" name="owner">

    <div class="grid gap-4">
      <h2>@lang('Title')</h2>
      <input type="text" name="title" value="{{$editing_case ? $stay['title'] : old('title') }}"/>  
      <h2>@lang('Description')</h2>
      <textarea name="description">{{$editing_case ? $stay['description'] : old('description')}}</textarea>      
      <h2>@lang('Address')</h2>
      <input type="text" name="address" value="{{$editing_case ? $stay['address'] : old('address')}}"/>  
      <div class="grid grid-cols-3 gap-4 [&>div]:grid [&>div]:gap-4">
        <div>
          <h2>@lang('Capacity')</h2>
          <input type="number" name="capacity" value="{{$editing_case ? $stay['capacity'] : old('capacity')}}" min="1"/>  
        </div>
        <div>
          <h2>@lang('Bedrooms')</h2>
          <input type="number" name="bedrooms" value="{{$editing_case ? $stay['bedrooms'] : old('bedrooms')}}" min="1"/>  
        </div>
        <div>
          <h2>@lang('Price per day')</h2>
          <input type="number" name="price" value="{{$editing_case ? $stay['price'] : old('price')}}"/>  
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4 [&>div]:grid [&>div]:gap-4">
        <div>
          <h2>@lang('Country')</h2>
          <select name="country">
            @foreach($possible_countries as $country)
              <option value="{{$country}}" {{$editing_case && ($stay['country'] == $country) || $country == 'France' ? 'selected' : ''}}>{{$country}}</option>
            @endforeach
          </select>
        </div>
        <div>
          <h2>@lang('City')</h2>
          <input type="text" name="city" value="{{$editing_case ? $stay['city'] : old('city')}}"/>
        </div>
      </div>
      @if(!$editing_case)
        <div>
          <h2>@lang('Images')</h2>
          <input type="file" name="images[]" placeholder="Images" multiple="TRUE"/>
        </div>
      @endif
    </div>

    <div>
      <x-map :editable="true"/>
      <input type="hidden" name="lat">
      <input type="hidden" name="lon">
    </div>

    <div class="col-span-2">
      <button type="submit" class="btn good w-full">@lang($submit_button)</button>
    </div>
  </form>
</main>
@endsection
