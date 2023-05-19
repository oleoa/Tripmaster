@extends('layouts.main')
@section('body')
  <div class="px-24 flex flex-col items-center justify-center py-4 space-y-4">
    <h1>@lang('Create Stay')</h1>
    <form action="{{route('my.create.stay')}}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">
      @csrf
      <input type="hidden" value="{{$owner}}" name="owner">
      <div>
        <h2>@lang('Title')</h2>
        <input type="text" name="title"/>
      </div>
      <div>
        <h2>@lang('Capacity')</h2>
        <input type="number" name="capacity"/>
      </div>
      <div class="col-span-2">
        <h2>@lang('Description')</h2>
        <textarea name="description" rows="3" class="bg-slate-500 rounded w-full text-white p-2"></textarea>
      </div>
      <div>
        <h2>@lang('Bedrooms')</h2>
        <input type="number" name="bedrooms"/>
      </div>
      <div>
        <h2>@lang('Price per month')</h2>
        <input type="number" name="price"/>
      </div>
      <div>
        <h2>@lang('Country')</h2>
        <input type="text" name="country"/>
      </div>
      <div>
        <h2>@lang('City')</h2>
        <input type="text" name="city"/>
      </div>
      <div class="col-span-2">
        <h2>@lang('Images')</h2>
        <input type="file" name="images[]" placeholder="Images" multiple="TRUE"/>
      </div>
      <div class="col-span-2">
        <input type="submit" value="@lang('Create')"/>
      </div>
    </form>
    <x-validate-errors :errors="$errors"/>
  </div>
@endsection