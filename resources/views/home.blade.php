@extends('layouts.main')
@section('body')
  <main class="font-mono grid-cols-5">
    <article class="space-y-4 col-span-2 p-4">
      <h1 class="">Organize and plan <br><span class="text-5xl">Your trip</span></h1>
      <p class="text-xl">
        Welcome to our comprehensive trip planning website! 
        Whether you're a seasoned globetrotter or a first-time traveler, 
        we are here to assist you in creating the perfect itinerary for your next adventure. 
        Our platform is designed to streamline the trip planning process 
        and provide you with all the tools and information you need to make your journey unforgettable.
      </p>
    </article>
    <img src="{{asset('images/aeroport.jpg')}}" alt="Aeroport" class="col-span-3">
  </main>
@endsection
