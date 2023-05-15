@extends('layouts.main')
@section('body')
  <div class="px-24 flex flex-col items-center justify-center py-4 space-y-4">
    <x-h1 :text="'Create Stay'"/>
    <form action="{{route('my.create.stay')}}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-4">
      @csrf
      <input type="hidden" value="{{$owner}}" name="owner">
      <div>
        <x-h2 :text="'Title'"/>
        <x-form.input :type="'text'" :name="'title'"/>
      </div>
      <div>
        <x-h2 :text="'Capacity'"/>
        <x-form.input :type="'number'" :name="'capacity'"/>
      </div>
      <div class="col-span-2">
        <x-h2 :text="'Description'"/>
        <textarea name="description" rows="3" class="bg-slate-500 rounded w-full text-white p-2"></textarea>
      </div>
      <div>
        <x-h2 :text="'Bedrooms'"/>
        <x-form.input :type="'number'" :name="'bedrooms'"/>
      </div>
      <div>
        <x-h2 :text="'Price per month'"/>
        <x-form.input :type="'number'" :name="'price'"/>
      </div>
      <div>
        <x-h2 :text="'Country'"/>
        <x-form.input :type="'text'" :name="'country'"/>
      </div>
      <div>
        <x-h2 :text="'City'"/>
        <x-form.input :type="'text'" :name="'city'"/>
      </div>
      <div class="col-span-2">
        <x-h2 :text="'Images'"/>
        <x-form.input :type="'file'" :name="'images[]'" :placeholder="'Images'" :multiple="TRUE"/>
      </div>
      <div class="col-span-2">
        <x-form.submit :value="'Create'"/>
      </div>
    </form>
    <x-validate-errors :errors="$errors"/>
  </div>
@endsection