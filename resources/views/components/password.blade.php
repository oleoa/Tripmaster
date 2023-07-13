@vite('resources/js/password.js')
<label for="password"><h2>@lang('Password')</h2></label>
<div class="flex relative">
  <input type="password" name="password" id="password" minlength="{{$min}}" maxlength="{{$max}}"/>
  <i class="far fa-eye text-white cursor-pointer absolute right-0 top-0 w-4 mr-8 mt-3" id="togglePassword"></i>
</div>
