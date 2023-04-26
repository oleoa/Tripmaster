@extends('layouts.main')
@section('body')
<div class="w-full flex justify-center items-center p-4">
  <form action="{{route('create.project')}}" method="POST" class="grid grid-cols-2 gap-4">
    @csrf
    <x-basics.h2 :text="'Title'"/>
    <x-form.input :type="'text'" :name="'title'"/>
    <x-basics.h2 :text="'Country'"/>
    <x-form.input :type="'text'" :name="'country'"/>    
    <x-basics.h2 :text="'Date'"/>
    <x-form.input :type="'date'" :name="'date'"/>    
    <x-basics.h2 :text="'How many people will join you in this adventure?'"/>
    <x-form.input :type="'integer'" :name="'headcount'"/>
      
    <input type="submit" value="Create">
  </form>
</div>
@endsection