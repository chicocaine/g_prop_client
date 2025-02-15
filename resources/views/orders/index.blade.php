<x-layout>
  <section class="px-6 py-8">
    <main class="max-w-lg mx-auto mt-10 bg-gray-100 p-6 rounded-xl border border-gray-200">
      <h1 class="text-center font-bold text-xl">Services we offer!</h1>
      <p class="text-center mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec nulla ac justo tincidunt fermentum</p>
    </main>
  </section>
  <section class="px-6 py-8 flex flex-col justify-start gap-3">
    <ul>
      @foreach ($orders as $order)
        <li>
          <a href="/services/{{ $order['id'] }}">
            <div class="text-left font-semibold text-xl text-blue-950 border border-gray-200 rounded p-4 m-4 bg-gray-100">
              <p>{{ $order['name'] }}</p>
            </div>
          </a>
        </li>
      @endforeach
    </ul>
  </section>
</x-layout>