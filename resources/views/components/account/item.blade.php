<div class="bg-slate-700 rounded flex flex-col items-center justify-center">
  <h2>{{$itemData['title']}}</h2>
  <h2>{{$itemData['howMany']}}</h2>
  <h2>{{$itemData['beingUsed']}}</h2>
  <div class="flex space-x-4 p-4">
    <x-link.button :name="$itemData['add']['text']" :href="$itemData['add']['href']"/>
    <x-link.button :name="$itemData['list']['text']" :href="$itemData['list']['href']"/>
  </div>
</div>
