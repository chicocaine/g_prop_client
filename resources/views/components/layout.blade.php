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
    <div class="container mx-auto min-w-[250px]">
      <div class="flex justify-between items-center py-4">
        <div>
          <a href="/" class="text-3xl font-bold text-gray-950 flex items-baseline mx-auto">G-Prop</a>
        </div>
        <div class="flex-1 text-center mx-auto">
          <x-nav-link href="/" type="a" :active="request()->is('/')">Home</x-nav-link>
          <x-nav-link href="/about" type="a" :active="request()->is('about')">About</x-nav-link>
          <x-nav-link href="/services" type="a" :active="request()->is('services')">Services</x-nav-link>
          <x-nav-link href="/pricing" type="a" :active="request()->is('pricing')">Pricing</x-nav-link>
          <x-nav-link href="/contact" type="a" :active="request()->is('contact')">Contact</x-nav-link>
        </div>
        <div class="flex items-center mx-auto">
          <x-nav-link href="/login" type="a" :active="request()->is('login')">Login</x-nav-link>
          <x-register-link href="/register" type="a" :active="request()->is('register')">Register</x-register-link>
        </div>
      </div>
    </div>
  </nav>  
  <section>
    {{ $slot }}
  </section>
</body>
</html>