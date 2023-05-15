@extends('layouts.main')
@section('body')
  <div class="p-4">
    <div class="flex flex-col items-center justify-center">
      <div class="w-24">
        <x-image :src="'https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg'" :alt="'User Image'" />
      </div>
      <div class="grid grid-cols-2 p-4">
        <x-h1 :text="'Name:'"/>
        <x-h1 :text="'User Name'"/>
        <x-h2 :text="'Email:'"/>
        <x-h2 :text="'User Email'"/>
        <x-h2 :text="'Tempo como user:'"/>
        <x-h2 :text="'User Tempo como user'"/>
        <x-h2 :text="'Número de projetos:'"/>
        <x-h2 :text="'User Número de projetos'"/>
      </div>
    </div>
    <div class="grid grid-cols-3 gap-4 px-24">
      <x-account.item :itemData="$stays"/>
      <x-account.item :itemData="$cars"/>
    </div>
  </div>
@endsection