<div class="bg-slate-700 rounded flex flex-col items-center justify-center">
  <x-h2 :text="$itemData['title']"/>
  <x-h2 :text="$itemData['howMany']"/>
  <x-h2 :text="$itemData['beingUsed']"/>
  <div class="flex space-x-4 p-4">
    <x-link.button :name="$itemData['add']['text']" :href="$itemData['add']['href']"/>
    <x-link.button :name="$itemData['list']['text']" :href="$itemData['list']['href']"/>
  </div>
</div>