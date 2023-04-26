<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>{{ $title }}</title>
</head>
<body class='{{ $theme }}'>
  <nav class='h-screen w-24 bg-blue-500 absolute left-0'>
    <x-sidebar/>
  </nav>
  <main class='pl-28 h-screen w-full bg-white dark:bg-slate-800'>
    @yield('body')
  </main>
</body>
</html>