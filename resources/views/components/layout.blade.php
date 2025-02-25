<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G-Prop Main</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
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

  <main id="container" class="pt-20">
    <x-landing.hero />
    <x-landing.about />
    <x-landing.services-products /> 
    <x-landing.contact />
    <x-landing.footer />
  </main>
</body>
</html>