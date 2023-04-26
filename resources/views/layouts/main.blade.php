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
  <nav class='h-screen w-48 border-r-2 border-slate-800 dark:border-slate-300 absolute left-0'>
    <x-sidebar.index :current="$current"/>
  </nav>
  <main class='pl-48 h-screen w-full bg-slate-300 dark:bg-slate-800'>
    @yield('body')
  </main>
</body>
</html>