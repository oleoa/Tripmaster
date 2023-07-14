@extends('layouts.main')
@section('body')
  <main>

    <div class="all-center relative">
      <div class="py-6">
        <h1>@lang('My Stays')</h1>
      </div>
      <div class="absolute right-0">
        <a href="{{route('stays.creator')}}" class="btn good">@lang('Create Stay')</a>
      </div>
    </div>
    
    @if(isset($stays) && !empty($stays) && count($stays) > 0)
      <div>
        <div class="grid grid-cols-7 w-full bg-slate-600 p-4 rounded-t">
          <h6>@lang('Image')</h6>
          <h6>@lang('Name')</h6>
          <h6>@lang('Status')</h6>
          <h6>@lang('Capacity')</h6>
          <h6>@lang('Price per day')</h6>
          <h6 class="text-end col-span-2">@lang('Actions')</h6>
        </div>
        <div class="grid grid-cols-1">
          @foreach ($stays as $stay)
            <div class="bg-slate-700 [&>h4]:flex [&>h4]:items-center text-white p-4 grid grid-cols-7 w-full @if($loop->last) rounded-b @else border-b-2 @endif">
              <img src="{{$stay->image}}" alt="Stay Image" class="w-24">
              <h4 class="pr-8">{{$stay['title']}}</h4>
              <h4>{{ucfirst($stay['status']);}}</h4>
              <h4>{{$stay['capacity']}}</h4>
              <h4>{{$stay['price']}}€</h4>
              <div class="flex items-center justify-end space-x-4 col-span-2">
                <a class="btn good" href="{{route("stays.dashboard", ['id' => $stay['id']])}}">@lang('Dashboard')</a>
                <a class="btn default" href="{{route("stays.show", ['id' => $stay['id']])}}">@lang('View')</a>
                <a class="btn okay" href="{{route('stays.editor', ['id' => $stay['id']])}}">@lang('Edit')</a>
                @if ($stay['status'] == 'enabled')
                  <a class="btn alert" href="{{route('stays.disable', ['id' => $stay['id']])}}">@lang('Disable')</a>
                @else
                  <a class="btn good" href="{{route('stays.enable', ['id' => $stay['id']])}}">@lang('Enable')</a>
                @endif
                <a class="btn danger" href="{{route('stays.delete', ['id' => $stay['id']])}}">@lang('Delete')</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @else
      <div class="bg-slate-700 p-4 rounded">
        <h4 class="text-center">@lang('No stays yet')</h4>
      </div>
    @endif

  </main>
@endsection
