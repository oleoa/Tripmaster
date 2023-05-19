@extends('layouts.main')
@section('body')
<div class="w-full grid justify-items-center p-4 gap-4">
  <div class="w-full border-2 border-slate-800 dark:border-slate-300 rounded">
    @if (isset($stays) && !empty($stays))
      <div class="flex flex-col p-4">
        <div class="flex items-center justify-center relative">
          <div class="py-6">
            <h1>@lang('Stays')</h1>
          </div>
          <div class="absolute right-0 top-0 p-4 pt-8">
            <a href="{{route('my.creator.stay')}}" class="btn">@lang('Create Stay')</a>
          </div>
        </div>
        <div class="grid gap-4 justify-items-start grid-cols-3">
          @foreach ($stays as $stay)
            <x-stay :stay="$stay"/>
          @endforeach
        </div>
      </div>
    @else
      <div class="flex items-center justify-center relative">
        <div class="py-6">
          <h1>@lang('You have no stays')</h1>
        </div>
        <div class="absolute right-0 top-0 p-4 pt-8">
          <a href="{{route('my.creator.stay')}}" class="btn">@lang('Create Stay')</a>
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
