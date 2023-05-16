<!DOCTYPE html>
<html lang="en">
<x-head :title="$title"/>
<body class='{{ $theme }}'>
  <nav class='h-full w-48 border-r-2 border-turquoise-200 dark:border-slate-300 fixed left-0'>
    <x-sidebar.index :current="$current" :logged="Auth::check()" :inverseTheme="$inverseTheme"/>
  </nav>
  <main class='pl-48 min-h-screen w-full bg-white dark:bg-slate-800'>
    @yield('body')
  </main>
</body>
</html>
