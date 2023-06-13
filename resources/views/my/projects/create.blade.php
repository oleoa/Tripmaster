@extends('layouts.main')
@section('body')
<div class="w-full flex flex-col justify-center items-center p-4">
  <div class="py-8 relative w-full flex items-center justify-center border-2 rounded p-4">
    <h1>@lang('Create Project')</h1>
    <div class="absolute right-0 p-8">
      <a href="{{route("my.list.projects")}}" class="btn-okay">@lang("List Projects")</a>
    </div>
  </div>
  <form action="{{route('my.create.project')}}" method="POST" class="grid grid-cols-2 gap-4">
    @csrf
    <div class="grid grid-rows-1 gap-4">
      <h2>@lang('Start')</h2>
      <input type="date" name="start"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <h2>@lang('End')</h2>
      <input type="date" name="end"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <h2>@lang('How many adults will participate?')</h2>
      <input type="number" name="adults" value="0"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <h2>@lang('How many children will participate?')</h2>
      <input type="number" name="children" value="0"/>
    </div>
    <div class="grid grid-rows-1 gap-4 col-span-2">
      <h2>@lang('Country')</h2>
      <select name="country" class="p-4 rounded bg-slate-400 dark:bg-slate-500 dark:text-white border-transparent" style="border-right-width: 1rem;">
        @foreach($countries as $country)
          <option value="{{$country}}" @if($country == $selected) selected @endif>{{$country}}</option>
        @endforeach
      </select>
    </div>
    <input type="submit" value="@lang('Create')" class="col-span-2 btn-good">
  </form>
</div>
@endsection
