<div class="bg-slate-700 rounded flex flex-col items-center justify-center">
  <h2>{{$itemData['title']}}</h2>
  <h2>{{$itemData['howMany']}}</h2>
  <h2>{{$itemData['beingUsed']}}</h2>
  <div class="flex space-x-4 p-4">
    <a href="{{$itemData['add']['href']}}">{{$itemData['add']['text']}}</a>
    <a href="{{$itemData['list']['href']}}">{{$itemData['list']['text']}}</a>
  </div>
</div>
