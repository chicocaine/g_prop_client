<div class="flex">
  <div class="ml-8 mr-20 px-4 sm:pl-6 min-w-[1235px]">
    <div class="flex flex-col">
      <div class="-m-1.5">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden  id="archive-container">
            <table class="min-w-full divide-y divide-gray-200 ">
              <tbody class="divide-y divide-gray-200" id="archive-tbody">
                @if ($commissions->isEmpty())
                  <div class="flex flex-col items-center justify-center align-center h-[763px] border border-gray-50 shadow-sm  rounded-[12px]">
                    <img src="load.svg" alt="No conversation selected" class="w-[77px] h-[77px]" />
                    <p class="my-8 text-gray-500  font-bold">No Completed Commissions.</p>
                    <p>Make a commission now :)))</p>
                  </div>
                @else
                @foreach ($commissions as $commission)
                  <tr class="archive-item bg-white hover:bg-gray-50  cursor-pointer" onclick="showMessages({{ $commission->id }})">
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                          <img src="{{ asset($commission->status . '.svg') }}" alt="{{ ucfirst($commission->status) }} Logo" width="16px" height="16px">
                      </td>
                       <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                          {{ $commission->status }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                          {{ $commission->details }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-50">
                          {{ Str::limit($commission->set_price, 50) }}
                      </td>
                  </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>