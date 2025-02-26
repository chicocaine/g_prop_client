<header class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
  <nav class="relative min-w-screen flex items-center justify-between px-16 py-4" aria-label="Global">
    <!-- Logo -->
    <div class="flex-shrink-0">
      <a href="/" class="text-xl font-bold">LOGO</a>
    </div>
    <!-- End Logo -->
    
    <!-- Collapse -->
    <div id="navbar-collapse" class="hs-collapse hidden md:flex md:items-center md:space-x-7">
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#hero">Home</a>
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#about">About</a>
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#services-products">Services & Products</a>
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#contact">Contact</a>
      
      @auth
        <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="{{route('user.details', Auth::user()->id)}}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
      @else
        <a class="text-[#F66C73] hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="{{ route('login') }}">Sign In</a>
      @endauth

    </div>
    <!-- End Collapse -->
  </nav>
</header>