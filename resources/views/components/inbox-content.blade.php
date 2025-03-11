 <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden " id="inbox-content">
          <table class="min-w-full divide-y divide-gray-200 ">
            <tbody class="divide-y divide-gray-200 ">
              @if ($commissions->isEmpty())
                <div class="flex flex-col items-center justify-center align-center w-[555px] h-[763px] border border-gray-50 shadow-sm  rounded-[12px]">
                  <img src="load.svg" alt="No conversation selected" class="w-[77px] h-[77px]" />

                  <p class="my-8 text-gray-500  font-bold">No Message Thread Created.</p>
                  <p >Make a message now :)))</p>
                </div>
              @else
              @foreach ($commissions as $commission)
                <tr class="bg-white hover:bg-gray-50  cursor-pointer" 
                    data-commission-id="{{ $commission->id }}"
                    onclick="showMessages({{ $commission->id }})">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                    {{ $commission->details }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                    {{ Str::limit($commission->description, 50) }}
                  </td>
                </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
