@vite('resources/css/toggle.css')
<label class="switch">
  <input type="checkbox" @if($isChecked) checked @endif name="{{$name}}">
  <span class="slider round"></span>
</label>
