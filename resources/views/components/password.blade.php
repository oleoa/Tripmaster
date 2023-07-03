@vite('resources/js/password.js')
<label for="password"><h2>@lang('Password')</h2></label>
<div class="flex">
  <input type="password" name="password" id="password" minlength="{{$min}}" maxlength="{{$max}}"/>
  <i class="far fa-eye pt-3 text-white cursor-pointer" style="margin-left: -2rem" id="togglePassword"></i>
</div>
