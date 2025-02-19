<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G-Prop Main</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script> 
</head>
<body>
  <nav>
    <x-nav-link/>
  </nav>  
  {{-- <section>
    {{ $slot }}
  </section> --}}

  <main id="container">
    <x-landing.hero />
    <x-landing.about />
  </main>
</body>
</html>