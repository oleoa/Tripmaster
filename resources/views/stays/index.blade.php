@extends('layouts.main')
@section('body')
  <div class="p-6 grid">
    <h1 class="text-center">Stays for {{$country}}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
      @foreach ($stays as $stay)
        <div class="bg-slate-700 rounded-lg shadow-lg overflow-hidden">
          <img class="w-full h-56 object-cover object-center" src="{{asset('storage/stays/'.$stay->image)}}" alt="{{$stay->title}}">
          <div class="p-4">
            <h1 class="text-2xl font-semibold">{{$stay->title}}</h1>
            <p class="mt-2 text-white">{{$stay->description}}</p>
            <div class="flex justify-between items-center mt-4">
              <a href="{{route('main', $stay->id)}}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">View</a>
              <span class="font-semibold text-xl text-white">{{$stay->price}}€</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
