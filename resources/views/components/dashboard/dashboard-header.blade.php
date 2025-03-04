<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<nav class="ml-20 fixed top-0 left-0 w-full flex items-center align-center justify-start px-4 bg-white shadow-md " aria-label="Global">
  <a href="/dashboard" class="text-xl font-bold">
    <img src="logo.svg" alt="logo" width="86px" height="56px">
  </a>

  <div class="mx-[24px] pt-[12px] font-bold">
    <p>COMMISIONS</p>
  </div>

  <form class="w-1/2 mx-[32px] h-[46px]">   
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
      </div>
      <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-[168px] bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Commision" required />
      {{-- <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button> --}}
    </div>
  </form>

  <div class="flex justify-end mr-32px w-1/6">
    @auth
      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="text-black hover:text-gray-600 dark:text-black dark:hover:text-neutral-300 focus:outline-none">
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
    @endauth
  </div>
</nav>