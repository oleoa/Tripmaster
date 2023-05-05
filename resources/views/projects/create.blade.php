@extends('layouts.main')
@section('body')
<div class="w-full flex flex-col justify-center items-center p-4">
  <div class="py-8">
    <x-h1 :text="__('Create Project')"/>
  </div>
  <form action="{{route('create.project')}}" method="POST" class="grid grid-cols-2 gap-4">
    @csrf
    <div class="grid grid-rows-1 gap-4">
      <x-h2 :text="__('Start')"/>
      <x-form.input :type="'date'" :name="'start'"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <x-h2 :text="__('End')"/>
      <x-form.input :type="'date'" :name="'end'"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <x-h2 :text="__('How many adults will participate?')"/>
      <x-form.input :type="'number'" :name="'adults'" :value="0"/>
    </div>
    <div class="grid grid-rows-1 gap-4">
      <x-h2 :text="__('How many children will participate?')"/>
      <x-form.input :type="'number'" :name="'children'" :value="0"/>
    </div>
    <div class="grid grid-rows-1 gap-4 col-span-2">
      <x-h2 :text="__('Country')"/>
      <select name="country" class="p-4 rounded bg-slate-400 dark:bg-slate-500 dark:text-white border-transparent" style="border-right-width: 1rem;">
        @foreach($countries as $country)
          <option value="{{$country}}" @if($country == $selected) selected @endif>{{$country}}</option>
        @endforeach
      </select>
    </div>
    <input type="submit" value="@lang('Create')" class="bg-green-600 col-span-2 p-4 rounded text-white">
  </form>
  <x-validateErrors :errors="$errors"/>
</div>
@endsection