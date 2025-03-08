<!-- Table Section -->
<div class="ml-8 px-4 py-10 sm:pl-6 lg:py-4">
  <!-- Card -->
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700" id="dashboard-container">
          <!-- Table -->
          <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <thead class="bg-gray-50 dark:bg-neutral-800">
              <tr>
                <th scope="col" class="px-6 py-3 text-start">
                  <a class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800 hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" href="#">
                    Status
                  </a>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                  <a class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800 hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" href="#">
                    ID
                  </a>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                  <a class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800 hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" href="#">
                    Subject
                  </a>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                  <a class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800 hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" href="#">
                    Description
                  </a>
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                  <a class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800 hover:text-gray-500 focus:outline-none focus:text-gray-500 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" href="#">
                    Date
                  </a>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700" id="dashboard-tbody">
              @foreach ($commissions as $commission)
                <tr class="dashboard-item bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 cursor-pointer" 
                    onclick="showCommissionDetails({{ $commission->id }}, '{{ $commission->status }}', '{{ addslashes($commission->subject) }}', `{{ addslashes($commission->details) }}`, '{{ $commission->created_at->format('M d, Y') }}', '{{ $commission->set_price ?? 'Not set' }}', '{{ $commission->user ? $commission->user->first_name . ' ' . $commission->user->last_name : 'Unknown' }}')">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-neutral-200">
                    <img src="{{ asset($commission->status . '.svg') }}" alt="{{ ucfirst($commission->status) }} Logo" width="16px" height="16px">
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                    {{ $commission->id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                    {{ $commission->subject }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                    {{ Str::limit($commission->details, 50) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                    {{ $commission->created_at->format('M d, Y') }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Table -->

          <!-- Footer -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
            <div>
              <p class="text-sm text-gray-600 dark:text-neutral-400">
                <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ $commissions->count() }}</span> results
              </p>
            </div>

            <div>
              <div class="inline-flex gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                  Prev
                </button>

                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                  Next
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </button>
              </div>
            </div>
          </div>
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Table Section -->

<!-- Commission Details Modal -->
<div id="commissionModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-black opacity-50"></div> <!-- Overlay -->

    <!-- Background overlay -->
    <div class="fixed inset-0 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeCommissionModal()"></div>
    
    <!-- Modal panel -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-800">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-gray-800">
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
              Commission Details
            </h3>
            <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600 dark:text-gray-300">ID:</span>
                <span class="text-gray-800 dark:text-white" id="modal-commission-id"></span>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600 dark:text-gray-300">Status:</span>
                <div class="flex items-center">
                  <span class="text-gray-800 dark:text-white mr-2" id="modal-status-text"></span>
                  <span class="w-3 h-3 rounded-full" id="modal-status-indicator"></span>
                </div>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600 dark:text-gray-300">Client:</span>
                <span class="text-gray-800 dark:text-white" id="modal-client"></span>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600 dark:text-gray-300">Date Created:</span>
                <span class="text-gray-800 dark:text-white" id="modal-date"></span>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600 dark:text-gray-300">Price:</span>
                <span class="text-gray-800 dark:text-white" id="modal-price"></span>
              </div>
              
              <div class="mb-4">
                <span class="font-medium text-gray-600 dark:text-gray-300">Subject:</span>
                <p class="mt-1 text-gray-800 dark:text-white" id="modal-subject"></p>
              </div>
              
              <div>
                <span class="font-medium text-gray-600 dark:text-gray-300">Details:</span>
                <div class="mt-2 p-3 bg-gray-50 rounded-md dark:bg-gray-700">
                  <p class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap" id="modal-details"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700">
        <button type="button" id="view-chat-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
          View Chat
        </button>
        <button type="button" onclick="closeCommissionModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-500">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  let currentCommissionId = null;

  function showCommissionDetails(id, status, subject, details, date, price, client) {
    currentCommissionId = id;
    
    // Update modal content
    document.getElementById('modal-commission-id').textContent = `Commission #${id}`;
    document.getElementById('modal-status-text').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    document.getElementById('modal-subject').textContent = subject;
    document.getElementById('modal-details').textContent = details;
    document.getElementById('modal-date').textContent = date;
    document.getElementById('modal-price').textContent = price;
    document.getElementById('modal-client').textContent = client;
    
    // Set status indicator color
    const statusIndicator = document.getElementById('modal-status-indicator');
    switch(status) {
      case 'pending':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-zinc-500';
        break;
      case 'active':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-yellow-500';
        break;
      case 'completed':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-green-500';
        break;
      case 'cancelled':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-red-500';
        break;
      default:
        statusIndicator.className = 'w-3 h-3 rounded-full bg-gray-500';
    }
    
    // Set up the View Chat button
    const viewChatBtn = document.getElementById('view-chat-btn');
    viewChatBtn.onclick = function() {
      window.location.href = `/inbox?commission=${id}`;
    };
    
    // Show the modal
    document.getElementById('commissionModal').classList.remove('hidden');
  }
  
  function closeCommissionModal() {
    document.getElementById('commissionModal').classList.add('hidden');
    currentCommissionId = null;
  }
  
  // Close modal when clicking Escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && !document.getElementById('commissionModal').classList.contains('hidden')) {
      closeCommissionModal();
    }
  });
</script>