<!-- Table Section -->
<div class="ml-8 px-4 py-10 sm:pl-6 lg:py-4">
  <!-- Card -->
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden" id="dashboard-container">
          @if($commissions->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-16 px-4">
              <img src="{{ asset('empty-commission.svg') }}" alt="No commissions" class="w-40 h-40 mb-4 opacity-70" 
                   onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2NjY2NjYyIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHJlY3QgeD0iMyIgeT0iNCIgd2lkdGg9IjE4IiBoZWlnaHQ9IjE4IiByeD0iMiIgcnk9IjIiPjwvcmVjdD48bGluZSB4MT0iMTYiIHkxPSIyIiB4Mj0iMTYiIHkyPSI2Ij48L2xpbmU+PGxpbmUgeDE9IjgiIHkxPSIyIiB4Mj0iOCIgeTI9IjYiPjwvbGluZT48bGluZSB4MT0iMyIgeTE9IjEwIiB4Mj0iMjEiIHkyPSIxMCI+PC9saW5lPjwvc3ZnPg==';">
              <h3 class="text-xl font-semibold text-gray-700 mb-2">No Commissions Found</h3>
              
              @if(request()->get('status'))
                <p class="text-gray-500 max-w-md text-center mb-6">
                  There are no commissions with status "{{ ucfirst(request()->get('status')) }}" at the moment.
                </p>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-x-2 py-2.5 px-4 rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-semibold">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                  </svg>
                  View All Commissions
                </a>
              @else
                <p class="text-gray-500 max-w-md text-center mb-6">
                  Your commission list is empty. Create a new commission to get started.
                </p>
                <a href="{{ route('inbox') }}" class="inline-flex items-center gap-x-2 py-2.5 px-4 rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-semibold">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                  </svg>
                  Create New Commission
                </a>
              @endif
            </div>
          @else
            <!-- Table Header -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
              <div>
                <h2 class="text-xl font-semibold text-gray-800">
                  @if(request()->get('status'))
                    {{ ucfirst(request()->get('status')) }} Commissions
                  @else
                    All Commissions
                  @endif
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manage your commission requests and progress</p>
              </div>
            </div>
            
            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr class="bg-gray-50">
                  <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Status</span>
                  </th>
                  <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-medium uppercase tracking-wider text-gray-500">ID</span>
                  </th>
                  <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Delivery Address</span>
                  </th>
                  <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Description</span>
                  </th>
                  <th scope="col" class="px-6 py-3 text-start">
                    <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Date</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200" id="dashboard-tbody">
                @foreach ($commissions as $commission)
                  <tr class="dashboard-item hover:bg-gray-50 transition-colors cursor-pointer" 
                      onclick="showCommissionDetails({{ $commission->id }}, '{{ $commission->status }}', '{{ addslashes($commission->delivery_address) }}', `{{ addslashes($commission->details) }}`, '{{ $commission->created_at->format('M d, Y') }}', '{{ $commission->set_price ?? 'Not set' }}', '{{ $commission->user ? $commission->user->first_name . ' ' . $commission->user->last_name : 'Unknown' }}')">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full 
                          @if($commission->status === 'active')
                            bg-green-100
                          @elseif($commission->status === 'completed')
                            bg-blue-100
                          @elseif($commission->status === 'pending')
                            bg-gray-100
                          @elseif($commission->status === 'cancelled')
                            bg-red-100
                          @else
                            bg-yellow-100
                          @endif
                        ">
                          <img src="{{ asset($commission->status . '.svg') }}" alt="{{ ucfirst($commission->status) }} Logo" width="16" height="16">
                        </div>
                        <div class="ml-4">
                          <span class="text-xs font-medium rounded-full px-2.5 py-1
                            @if($commission->status === 'active')
                              bg-green-100 text-green-800
                            @elseif($commission->status === 'completed')
                              bg-blue-100 text-blue-800
                            @elseif($commission->status === 'pending')
                              bg-gray-100 text-gray-800
                            @elseif($commission->status === 'cancelled')
                              bg-red-100 text-red-800
                            @else
                              bg-yellow-100 text-yellow-800
                            @endif
                          ">
                            {{ ucfirst($commission->status) }}
                          </span>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="text-sm font-medium text-gray-900">#{{ $commission->id }}</span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-900 font-medium">{{ $commission->delivery_address }}</div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-500 max-w-xs truncate">
                        {{ Str::limit($commission->details, 50) }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">{{ $commission->created_at->format('M d, Y') }}</div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table -->

            <!-- Footer -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
              <div>
                <p class="text-sm text-gray-600">
                  Showing <span class="font-semibold text-gray-800">{{ $commissions->count() }}</span> commissions
                </p>
              </div>

              <div>
                <div class="inline-flex gap-x-2">
                  <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    Prev
                  </button>

                  <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                    Next
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                  </button>
                </div>
              </div>
            </div>
            <!-- End Footer -->
          @endif
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
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Commission Details
            </h3>
            <div class="mt-4 border-t border-gray-200 pt-4">
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600">ID:</span>
                <span class="text-gray-800" id="modal-commission-id"></span>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600">Status:</span>
                <div class="flex items-center">
                  <span class="text-gray-800 mr-2" id="modal-status-text"></span>
                  <span class="w-3 h-3 rounded-full" id="modal-status-indicator"></span>
                </div>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600">Client:</span>
                <span class="text-gray-800" id="modal-client"></span>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600">Date Created:</span>
                <span class="text-gray-800" id="modal-date"></span>
              </div>
              
              <div class="flex justify-between mb-2">
                <span class="font-medium text-gray-600">Price:</span>
                <span class="text-gray-800" id="modal-price"></span>
              </div>
              
              <div class="mb-4">
                <span class="font-medium text-gray-600">Delivery Address:</span>
                <p class="mt-1 text-gray-800" id="modal-address"></p>
              </div>
              
              <div>
                <span class="font-medium text-gray-600">Details:</span>
                <div class="mt-2 p-3 bg-gray-50 rounded-md">
                  <p class="text-gray-800 whitespace-pre-wrap" id="modal-details"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" id="view-chat-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
          View Chat
        </button>
        <button type="button" onclick="closeCommissionModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  let currentCommissionId = null;

  function showCommissionDetails(id, status, address, details, date, price, client) {
    currentCommissionId = id;
    
    // Update modal content
    document.getElementById('modal-commission-id').textContent = `Commission #${id}`;
    document.getElementById('modal-status-text').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    document.getElementById('modal-address').textContent = address;
    document.getElementById('modal-details').textContent = details;
    document.getElementById('modal-date').textContent = date;
    document.getElementById('modal-price').textContent = price;
    document.getElementById('modal-client').textContent = client;
    
    // Set status indicator color
    const statusIndicator = document.getElementById('modal-status-indicator');
    switch(status) {
      case 'pending':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-gray-500';
        break;
      case 'active':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-green-500';
        break;
      case 'completed':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-blue-500';
        break;
      case 'cancelled':
        statusIndicator.className = 'w-3 h-3 rounded-full bg-red-500';
        break;
      default:
        statusIndicator.className = 'w-3 h-3 rounded-full bg-yellow-500';
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
  
  // Make pagination buttons work if available
  document.addEventListener('DOMContentLoaded', function() {
    const prevButton = document.querySelector('button:contains("Prev")');
    const nextButton = document.querySelector('button:contains("Next")');
    
    if (prevButton && nextButton) {
      // Add pagination logic here if needed
    }
  });
</script>