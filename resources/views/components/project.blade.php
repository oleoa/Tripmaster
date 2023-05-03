<div class="dark:bg-slate-700 bg-turquoise-100 text-white rounded p-4 grid grid-cols-2">
  <div class="w-96 space-y-4">
    <x-h1 :text="$project->country"/>
    <x-h2 :text="$project->date"/>
    <x-h2 :text="$project->headcount.' '.__('people')"/>
  </div>
  <div class="flex items-end justify-end">
    <img src="https://media.cntraveler.com/photos/58de89946c3567139f9b6cca/1:1/w_3633,h_3633,c_limit/GettyImages-468366251.jpg" alt="Country Picture" class="rounded">
  </div>
</div>
