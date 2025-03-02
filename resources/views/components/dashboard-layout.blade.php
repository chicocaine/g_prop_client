<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Commisions</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
      <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>
  <nav>
    <x-dashboard.dashboard-sidebar/>
  </nav>  

  <main id="container" class="flex">
    @yield('content')
  </main>
</body>
</html>