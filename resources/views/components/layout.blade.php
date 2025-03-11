<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G-Prop Main</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>
  <nav>
    <x-nav-link/>
  </nav>  
  {{-- <section>
    {{ $slot }}
  </section> --}}

  <main id="container flex items-center justify-center">
    <x-landing.hero />
    <x-landing.about />
    <x-landing.services-products /> 
    <x-landing.contact />
    <x-landing.footer />
  </main>
</body>
</html>