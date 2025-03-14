  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<header class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
  <nav class="relative min-w-screen flex items-center justify-between px-16 py-4" aria-label="Global">
    <!-- Logo -->
    <div class="flex-shrink-0">
      <a href="/" class="text-xl font-bold">
      <img src="logo.svg" alt="LOGO" width="80px" height="80px">
      </a>
    </div>
    <!-- End Logo -->
    
    <!-- Collapse -->
    <div id="navbar-collapse" class="hs-collapse hidden md:flex md:items-center md:space-x-7">
      <a class="text-black hover:text-gray-600 " href="/#hero">Home</a>
      <a class="text-black hover:text-gray-600 " href="/#about">About</a>
      <a class="text-black hover:text-gray-600 " href="/#services-products">Services & Products</a>
      <a class="text-black hover:text-gray-600 " href="/#contact">Contact</a>
      
      @auth
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" class="text-[#F66C73] hover:text-gray-600  focus:outline-none">
            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
          </button>
          <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-20">
            <a href="{{ route('user.details', Auth::user()->id) }}" @click="open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Profile</a>
            <a href="{{ route('dashboard') }}" @click="open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Go to Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" @click="open = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
            </form>
          </div>
        </div>
      @else
        <a class="text-[#F66C73] hover:text-gray-600 " href="{{ route('login') }}">Sign In</a>
      @endauth

    </div>
    <!-- End Collapse -->
  </nav>
</header>