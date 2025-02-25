<!-- filepath: /home/matchan/Documents/2nd-Year-BSCS/CSE-7/Final-Project/g_prop_client/resources/views/components/nav-link.blade.php -->
<header class="flex flex-wrap items-center justify-between w-full py-7">
  <nav class="relative min-w-screen flex items-center justify-between px-16" aria-label="Global">
    <!-- Logo -->
    <div class="flex-shrink-0">
      <a href="#" class="text-xl font-bold">LOGO</a>
    </div>
    <!-- End Logo -->
    
    <!-- Collapse -->
    <div id="navbar-collapse" class="hs-collapse hidden md:flex md:items-center md:space-x-7">
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#">Home</a>
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#">About</a>
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#">Services & Products</a>
      <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#">Contact</a>
      
      @auth
        <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="#">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
      @else
        <a class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300" href="{{ route('login') }}">Sign In</a>
      @endauth

    </div>
    <!-- End Collapse -->
  </nav>
</header>