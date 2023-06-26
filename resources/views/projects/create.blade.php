@extends('layouts.main')
@section('body')
<main>
  <div class="relative w-full flex items-center justify-center p-4">
    <h1>@lang('Create Project')</h1>
    <div class="absolute right-0 p-8">
      <a href="{{route("projects.list")}}" class="btn okay">@lang("List Projects")</a>
    </div>
  </div>
  <form action="{{route('projects.create')}}" method="POST" class="grid grid-cols-2 gap-4">
    @csrf
    <div>
      <x-full-calendar/>
    </div>
    <div class="flex flex-col space-y-4">
      <div class="grid grid-rows-1 gap-4">
        <h2>@lang('How many adults will participate')?</h2>
        <input type="number" name="adults" value="0"/>
      </div>
      <div class="grid grid-rows-1 gap-4">
        <h2>@lang('How many children will participate')?</h2>
        <input type="number" name="children" value="0"/>
      </div>
      <div class="grid grid-rows-1 gap-4">
        <h2>@lang('Country')</h2>
        <select name="country" class="p-4" style="border-right-width: 1rem;">
          @foreach($countries as $country)
            <option value="{{$country}}" @if($country == $selected) selected @endif>{{$country}}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn good">@lang('Create')</button>
      <input type="hidden" name="start" id="start" min="{{$minStart}}"/>
      <input type="hidden" name="end" id="end" min="{{$minEnd}}"/>
    </div>
  </form>
</main>
@endsection
