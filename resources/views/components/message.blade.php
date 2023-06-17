@if($message)
  <div id="opc" class="fixed top-0 right-0 w-full bg-slate-700/50 h-full">
    <dialog class="bg-white rounded my-4 w-1/3" open>
      <h1 class="message {{$type}}">@lang($title):</h1>
      <p class="text-xl py-4 message {{$type}}"><strong><code>@lang($message)<code><strong></p>
      <form method="dialog" class="text-end">
        <button class="btn {{$type}} text-white" onclick="document.querySelector('#opc').style.display = 'none'">OK</button>
      </form>
    </dialog>
  </div>
@endif
