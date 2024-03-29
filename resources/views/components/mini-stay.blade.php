@if(isset($stay) && !empty($stay))
  <div class="overflow-hidden flex">
    <img class="w-60 object-cover object-center" src="{{$stay->image}}" alt="{{$stay->title}}">
    <div class="px-4">
      <h1 class="text-2xl font-semibold">{{$stay->title}}</h1>
      <p class="mt-2 text-white">{{$stay->description}}</p>
      <span class="font-semibold text-white">{{$stay->price}}€</span>
      <div class="flex justify-start space-x-4 items-center mt-4">
        <a href="{{route('stays.show', $stay->id)}}" class="btn okay">View</a>
        <a href="{{route('projects.stays.remove', $stay->id)}}" class="btn danger">Remove</a>
      </div>
    </div>
    <div class="text-center">
      <h3>{{$stay->start}}</h3>
      <h3>{{$stay->end}}</h3>
    </div>
  </div>
@endif
