@props(['active' => false, 'type' => 'a'])

@if ($type == 'button')
  <button class="px-4 py-2 inline-block" {{ $attributes }}>
    <div class=" border border-gray-300 rounded-full px-4 py-2 {{ $active ? 'font-semibold text-gray-950 bg-red-100' :  'font-semibold text-gray-950 bg-white hover:bg-red-100 transition delay-150 duration-300s ease-in-out' }}"
    aria-current="{{ $active ? 'page' : 'false' }}"
    {{ $attributes }}
    >
      {{ $slot }}
    </div>
  </button>

@elseif ($type == 'a')
  <a class="px-4 py-2 inline-block" {{ $attributes }}>
    <div class=" border border-gray-300 rounded-full px-4 py-2 {{ $active ? 'font-semibold text-gray-950 bg-red-100' :  'font-semibold text-gray-950 bg-white hover:bg-red-100 transition delay-150 duration-300s ease-in-out' }}"
    aria-current="{{ $active ? 'page' : 'false' }}"
    {{ $attributes }}
    >
      {{ $slot }}
    </div>
  </a>
@endif