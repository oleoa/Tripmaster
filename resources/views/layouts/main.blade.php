<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>@lang($title)</title>
</head>
<body class='{{ $theme }}'>
  <nav class='h-full w-48 border-r-2 border-turquoise-200 dark:border-slate-300 fixed left-0'>
    <x-sidebar.index :current="$current" :logged="Auth::check()" :inverseTheme="$inverseTheme"/>
  </nav>
  <main class='pl-48 min-h-screen w-full bg-white dark:bg-slate-800'>
    @yield('body')
  </main>
</body>
</html>
