@props(['active' => false])
@props(['type'])

@if ($type == 'button')
  <button class="px-4 py-2 inline-block" {{ $attributes }}>
    <div class="{{ $active ? 'font-bold' : 'text-gray-950 bg-white font-medium  hover:font-bold transition delay-150 duration-300s ease-in-out' }} px-4 py-2 text-gray-950"
    aria-current="{{ $active ? 'page' : 'false' }}"
    {{ $attributes }}
    >
      {{ $slot }}
    </div>
  </button>

@elseif ($type == 'a')
  <a class="px-4 py-2 inline-block" {{ $attributes }}>
    <div class="{{ $active ? 'font-bold' : 'text-gray-950 bg-white font-medium  hover:font-bold transition delay-150 duration-300s ease-in-out' }} px-4 py-2 text-gray-950"
    aria-current="{{ $active ? 'page' : 'false' }}"
    {{ $attributes }}
    >
      {{ $slot }}
    </div>
  </a>
@endif