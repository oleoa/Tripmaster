<!DOCTYPE html>
<html lang="en">

  <x-head :title="$title"/>

  <body>

    <nav class='h-full w-16 lg:w-48 fixed left-0 top-0 flex flex-col justify-between bg-slate-950'>

      <div>

        <div class="flex-col items-center justify-start pt-2 pb-4 flex">
          <div class="py-6">
            <a class="no-underline" href="{{route('home')}}">
              <h1 class="hidden lg:block">@lang('Tripmaster')</h1>
              <i class="block lg:hidden text-2xl fa-solid fa-earth-americas"></i>
            </a>
          </div>
          <div class="h-0.5 w-full bg-slate-300"></div>
        </div>

        @if($isLogged)
          <div class="grid gap-6 px-4 justify-items-start [&>a]:text-2xl">

            <a href="{{route('projects.index')}}" class="a-nav">
              <span class="hidden lg:block pr-2 @if($current['main']) underline @endif">
                @lang('Main')
              </span>
              <i class="fa-solid fa-house"></i>
            </a>

            <a href="{{route('stays.index')}}" class="a-nav">
              <span class="hidden lg:block pr-2 @if($current['stays']) underline @endif">
                @lang('Stays')
              </span>
              <i class="fa-solid fa-bed"></i>
            </a>

          </div>
        @endif

      </div>

      <div>

        @if (!$isLogged)

          <div class="px-4 py-6 grid gap-6 [&>a]:text-2xl">
            <a href="{{route('contact')}}" class="a-nav">
              <span class="hidden lg:block pr-2 @if($current['contact']) underline @endif">
                @lang('Contact us')
              </span>
              <i class="fa-solid fa-envelope"></i>
            </a>
          </div>

        @endif
        
        @if($isLogged)
          <div class="px-4 py-6 grid gap-6 [&>a]:text-2xl">
            <a href="{{route('contact')}}" class="a-nav">
              <span class="hidden lg:block pr-2 @if($current['contact']) underline @endif">
                @lang('Contact us')
              </span>
              <i class="fa-solid fa-envelope"></i>
            </a>
            <a href="{{route('account.index')}}" class="a-nav">
              <span class="hidden lg:block pr-2 @if($current['account']) underline @endif">
                @lang('Account')
              </span>
              <i class="fa-solid fa-user"></i>
            </a>
          </div>
        @endif

        <div class="h-0.5 w-full bg-slate-300"></div>

        <div class="px-4 grid grid-cols-3 [&>a]:text-2xl space-y-6 py-6">
          @if ($isLogged)

            <a class="a-nav col-span-3" href="{{route('sign.out')}}">
              <span class="hidden lg:block pr-2 @if($current['contact']) underline @endif">
                @lang('Sign out')
              </span>
              <i class="fa-solid fa-sign-out"></i>
            </a>

            <details class="col-span-2 text-white text-2xl">
              <summary class="">@lang('Langs')</summary>
              <a href="{{route('language', ['locale' => 'pt'])}}">@lang('Portuguese')</a>
              <a href="{{route('language', ['locale' => 'en'])}}">@lang('English')</a>
            </details>
          @else
            <a href="{{route('sign.in')}}" class="col-span-3 a-nav">
              <span class="hidden lg:block pr-2 @if($current['signin']) underline @endif">
                @lang('Sign in')
              </span>
              <i class="fa-solid fa-sign-in"></i>
            </a>

            <a href="{{route('sign.up')}}" class="col-span-3 a-nav">
              <span class="hidden lg:block pr-2 @if($current['signup']) underline @endif">
                @lang('Sign up')
              </span>
              <i class="fa-solid fa-user-plus"></i>
            </a>
          @endif
          
        </div>

      </div>
    </nav>

    <div class='pl-20 lg:pl-52 p-4 min-h-screen w-full bg-slate-800'>
      @yield('body')
    </div>
    
    @if($errors->any())
      <div id="opc" class="fixed top-0 right-0 w-full bg-slate-700/50 h-full z-40">
        <dialog class="bg-slate-950 rounded my-4 w-1/2 z-50" open>
          <h1 class="text-yellow-500">@lang('Alert'):</h1>
          @foreach ($errors->all() as $error)
            @if($error == 'The password field format is invalid.')
              <p class="text-xl text-yellow-500 py-4"><strong><code>@lang('The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character from the set [@ $ ! % * # ? &] to meet the minimum security requirements.')<code><strong></p>
            @else
              <p class="text-xl text-yellow-500 py-4"><strong><code>@lang($error)<code><strong></p>
            @endif
          @endforeach
          <form method="dialog" class="text-end">
            <button class="btn alert text-white z-50" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
          </form>
        </dialog>
      </div>
    @endif

    <x-message :message="session('alert')" :title="'Alert'" :type="'alert'"/>
    <x-message :message="session('error')" :title="'Error'" :type="'danger'"/>
    <x-message :message="session('info')" :title="'Info'" :type="'okay'"/>
    <x-message :message="session('success')" :title="'Success'" :type="'good'"/>

  </body>
</html>
