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
    <div class="container mx-auto">
      <div class="flex justify-between items-center py-4">
      <div>
        <a href="/" class="text-3xl font-bold text-gray-950 flex items-baseline">G-Prop</a>
      </div>
      <div class="flex-1 text-center">
        <a href="#" class="px-4 py-2 text-gray-950 font-medium">Home</a>
        <a href="#" class="px-4 py-2 text-gray-950 font-medium">About</a>
        <a href="#" class="px-4 py-2 text-gray-950 font-medium">Services</a>
        <a href="#" class="px-4 py-2 text-gray-950 font-medium">Pricing</a>
        <a href="#" class="px-4 py-2 text-gray-950 font-medium">Contact</a>
      </div>
      <div>
        <a href="#" class="px-4 py-2 text-gray-950">Login</a>
        <div class="inline-block border border-gray-300 rounded-full px-4 py-2">
        <a href="#" class="px-4 py-2 font-semibold text-gray-950">Register</a>
        </div>
      </div>
      </div>
    </div>
  </nav>
  <section class="flex min-h-screen items-center bg-white">
    <div class="container mx-auto flex flex-row items-center">
      <div class="w-full lg:w-3/5 px-6 lg:px-16 text-center lg:text-left w-3/5">
        <h1 class="text-5xl font-bold text-gray-900 leading-tight">
          Great tool to boost <br /> your startup
        </h1>
        <p class="text-lg text-gray-500 mt-4">
          We made it so beautiful and simple. It combines landings, pages, 
          blogs, and shop screens. It is definitely the tool you need in your collection!
        </p>
        <div class="mt-6 flex justify-center lg:justify-start gap-4">
          <a
            href="#"
            class="px-6 py-3 bg-green-500 text-white font-semibold text-lg rounded-full shadow-md hover:bg-green-600 transition"
          >
            Get Started
          </a>
          <a
            href="#"
            class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold text-lg rounded-full shadow-md hover:bg-gray-100 transition"
          >
            Learn More
          </a>
        </div>
        <p class="text-sm text-gray-400 mt-4">
          By signing up, you agree to the Terms of Service
        </p>
      </div>
      <div class="w-2/5">
          <img
          src="https://images.pexels.com/photos/1055691/pexels-photo-1055691.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
          alt="Landing Image"
          class="w-full h-full object-cover"
        />
      </div>
    </div>
  </section>
  <section class="flex flex-col items-center bg-white">
    <div class="container mx-auto flex flex-col items-center">
      <div class="flex flex-row justify-center gap-4 mx-auto mb-10">
        <h2 class="text-5xl font-bold text-gray-900 text-center">What do we offer?</h2>
      </div>
      <div class="flex flex-row justify-center gap-4 mt-3">
          <p class="text-xl font-normal text-gray-400 text-center mx-auto">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, blanditiis? <br />
          Quia obcaecati maxime harum quas autem excepturi.
          </p>
      </div>
    </div>
    <div class="container mx-auto flex flex-row items-center justify-center gap-4 mt-10">
      <div class="w-96 min-h-100 bg-white rounded-2xl shadow-lg border border-gray-400 p-8 flex flex-col items-center text-center">
        <div class="w-30 h-30 bg-blue-100 flex items-center justify-center rounded-full">
          <svg class="w-15 h-15 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m0-4h.01M12 20h.01M21 12.95A9 9 0 1112 3a9 9 0 019 9z" />
          </svg>
        </div>
        <div>
          <h2 class="text-3xl font-semibold text-gray-800 mt-4">Card Title</h2>
          <p class="text-gray-600 mt-5 text-xl font-xl">
            This is a simple card component with an icon, a heading, and some text.
          </p>
        </div>
      </div>
      <div class="w-96 min-h-100 bg-white rounded-2xl shadow-lg border border-gray-400 p-8 flex flex-col items-center text-center">
        <div class="w-30 h-30 bg-blue-100 flex items-center justify-center rounded-full">
          <svg class="w-15 h-15 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m0-4h.01M12 20h.01M21 12.95A9 9 0 1112 3a9 9 0 019 9z" />
          </svg>
        </div>
        <div>
          <h2 class="text-3xl font-semibold text-gray-800 mt-4">Card Title</h2>
          <p class="text-gray-600 mt-5 text-xl font-xl">
            This is a simple card component with an icon, a heading, and some text.
          </p>
        </div>
      </div>
      <div class="w-96 min-h-100 bg-white rounded-2xl shadow-lg border border-gray-400 p-8 flex flex-col items-center text-center">
        <div class="w-30 h-30 bg-blue-100 flex items-center justify-center rounded-full">
          <svg class="w-15 h-15 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m0-4h.01M12 20h.01M21 12.95A9 9 0 1112 3a9 9 0 019 9z" />
          </svg>
        </div>
        <div>
          <h2 class="text-3xl font-semibold text-gray-800 mt-4">Card Title</h2>
          <p class="text-gray-600 mt-5 text-xl font-xl">
            This is a simple card component with an icon, a heading, and some text.
          </p>
        </div>
      </div>
    </div>
  </section>
  <section class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto text-center">
        <h3 class="text-sm font-semibold text-gray-500 tracking-wide uppercase">Pricing Plan</h3>
        <h2 class="text-4xl font-bold text-gray-900 mt-2">Clear & Simple</h2>
    </div>

    {{-- Pricing Cards --}}
    <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
        @foreach([
            ['title' => 'Free', 'price' => '$0/month', 'icon' => '⚡', 'features' => ['Up to 5 Members', 'Backups for 2 Weeks', '50 Mb per File', '100 Messages'], 'buttonColor' => 'border-gray-300 text-gray-800'],
            ['title' => 'Starter', 'price' => '$9.99/month', 'icon' => '💣', 'features' => ['Up to 10 Members', 'Backups for 2 Months', '250 Mb per File', '1000 Messages'], 'buttonColor' => 'border-gray-300 text-gray-800'],
            ['title' => 'Standard', 'price' => '$19.99/month', 'icon' => '❤️', 'features' => ['Up to 20 Members', 'Backups for 6 Months', 'Unlimited Size per File', 'Unlimited Messages'], 'buttonColor' => 'bg-green-500 text-white'],
            ['title' => 'Enterprise', 'price' => '$49.99/month', 'icon' => '🏢', 'features' => ['Up to 20 Members', 'Backups for 12 Months', 'Unlimited Size per File', 'Unlimited Messages'], 'buttonColor' => 'border-gray-300 text-gray-800']
        ] as $plan)
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <h3 class="text-xl font-semibold text-gray-900">{{ $plan['title'] }}</h3>
                <p class="text-gray-500">{{ $plan['price'] }}</p>

                {{-- Icon Placeholder --}}
                <div class="flex items-center justify-center w-20 h-20 mx-auto my-4 bg-gray-200 rounded-full text-4xl">
                    {{ $plan['icon'] }}
                </div>

                <button class="px-6 py-2 rounded-full font-semibold text-lg border {{ $plan['buttonColor'] }} transition duration-300 hover:opacity-80">
                    Get Started
                </button>

                {{-- Features List --}}
                <ul class="mt-6 space-y-1 text-gray-700">
                    @foreach($plan['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</section>
</body>
</html>