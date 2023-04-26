@extends('layouts.main')
@section('body')
<div class="w-full flex flex-col justify-center items-center p-4">
  <div class="py-8">
    <x-basics.h1 :text="__('Create Project')"/>
  </div>
  <form action="{{route('create.project')}}" method="POST" class="grid grid-cols-1 gap-4">
    @csrf
    <div class="grid grid-rows-1 gap-4">
      <x-basics.h2 :text="__('Title')"/>
      <x-form.input :type="'text'" :name="'title'"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <x-basics.h2 :text="__('Country')"/>
      <select name="country" class="p-4 rounded bg-slate-400 dark:bg-slate-500 dark:text-white border-transparent" style="border-right-width: 1rem;">
        @foreach($countries as $country)
          <option value="{{$country}}">{{$country}}</option>
        @endforeach
      </select>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <x-basics.h2 :text="__('Date')"/>
      <x-form.input :type="'date'" :name="'date'"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <x-basics.h2 :text="__('How many people will join you in this adventure?')"/>
      <x-form.input :type="'number'" :name="'headcount'"/>
    </div>
    <input type="submit" value="@lang('Create')" class="bg-green-600 p-4 rounded text-white">
  </form>
</div>
@endsection