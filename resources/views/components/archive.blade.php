<div class="flex">
  <div class="ml-8 mr-20 px-4 sm:pl-6 min-w-[1235px]">
    <div class="flex flex-col">
      <div class="-m-1.5">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden" id="archive-container">
            <!-- Table Header -->
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
              <div>
                <h2 class="text-xl font-semibold text-gray-800">Archived Commissions</h2>
                <p class="text-sm text-gray-600 mt-1">View your completed commissions</p>
              </div>
            </div>
            
            @if ($commissions->isEmpty())
              <!-- Empty State -->
              <div class="flex flex-col items-center justify-center py-16 px-4 h-[600px]">
                <img src="" alt="No archived commissions" class="w-40 h-40 mb-4 opacity-70" 
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2NjY2NjYyIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTIxIDh2MTNINGExIDEgMCAwMS0xLTFWOGgxOHoiPjwvcGF0aD48cGF0aCBkPSJNMSAzaDIybTAgM0gyTTE1IDIxdi04bS02IDB2OCIvPjwvc3ZnPg==';">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Archived Commissions</h3>
                <p class="text-gray-500 max-w-md text-center mb-6">
                  You don't have any completed or cancelled commissions yet.
                </p>
              </div>
            @else
              <!-- Table with data -->
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
                      <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Details</span>
                    </th>
                    <th scope="col" class="px-6 py-3 text-start">
                      <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Price</span>
                    </th>
                    <th scope="col" class="px-6 py-3 text-start">
                      <span class="text-xs font-medium uppercase tracking-wider text-gray-500">Date</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="archive-tbody">
                  @foreach ($commissions as $commission)
                    <tr class="archive-item hover:bg-gray-50 transition-colors cursor-pointer" 
                        onclick="showArchiveDetails({{ $commission->id }}, '{{ $commission->status }}', '{{ addslashes($commission->delivery_address) }}', '{{ addslashes($commission->details) }}', '{{ $commission->created_at->format('M d, Y') }}', '{{ $commission->set_price ?? 'Not set' }}', '{{ $commission->user ? $commission->user->first_name . ' ' . $commission->user->last_name : 'Unknown' }}')">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full 
                            @if($commission->status === 'completed')
                              bg-blue-100
                            @elseif($commission->status === 'cancelled')
                              bg-red-100
                            @else
                              bg-gray-100
                            @endif
                          ">
                            <img src="{{ asset($commission->status . '.svg') }}" alt="{{ ucfirst($commission->status) }} Logo" width="16" height="16">
                          </div>
                          <div class="ml-4">
                            <span class="text-xs font-medium rounded-full px-2.5 py-1
                              @if($commission->status === 'completed')
                                bg-blue-100 text-blue-800
                              @elseif($commission->status === 'cancelled')
                                bg-red-100 text-red-800
                              @else
                                bg-gray-100 text-gray-800
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
                          {{ Str::limit($commission->details, 40) }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-700">
                          @if($commission->set_price)
                            PHP {{ number_format($commission->set_price, 2) }}
                          @else
                            Not set
                          @endif
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $commission->created_at->format('M d, Y') }}</div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              
              <!-- Pagination -->
              <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
                <div>
                  <p class="text-sm text-gray-600">
                    Showing <span class="font-semibold text-gray-800">{{ $commissions->count() }}</span> archived commissions
                  </p>
                </div>
                
                @if($commissions instanceof \Illuminate\Pagination\LengthAwarePaginator)
                  <div>
                    {{ $commissions->links() }}
                  </div>
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Archive Details Modal -->
<div id="archiveModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-center justify-center min-h-screen p-4">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black opacity-50 transition-opacity" aria-hidden="true" onclick="closeArchiveModal()"></div>
    
    <!-- Modal panel -->
    <div class="relative bg-white rounded-lg max-w-xl w-full mx-auto shadow-xl transform transition-all">
      <!-- Modal header -->
      <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
        <h3 class="text-xl font-semibold text-gray-900" id="modal-commission-address">
          Commission Details
        </h3>
        <button type="button" onclick="closeArchiveModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
      </div>
      
      <!-- Modal body -->
      <div class="p-4 md:p-5 space-y-4">
        <!-- Status Badge -->
        <div class="flex justify-center mb-6">
          <span id="modal-status-badge" class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium">
            <span id="modal-status-indicator" class="w-2.5 h-2.5 rounded-full me-1.5"></span>
            <span id="modal-status-text">Status</span>
          </span>
        </div>
        
        <!-- Commission Info -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="text-sm font-medium text-gray-500">Commission ID</p>
            <p id="modal-commission-id" class="text-base font-semibold text-gray-900">#123</p>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500">Creation Date</p>
            <p id="modal-date" class="text-base font-semibold text-gray-900">Jan 01, 2023</p>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500">Client</p>
            <p id="modal-client" class="text-base font-semibold text-gray-900">John Doe</p>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-500">Final Price</p>
            <p id="modal-price" class="text-base font-semibold text-gray-900">$100.00</p>
          </div>
        </div>
        
        <!-- Commission Details -->
        <div class="mt-4">
          <p class="text-sm font-medium text-gray-500">Details</p>
          <div class="mt-2 p-4 bg-gray-50 rounded-md">
            <p id="modal-details" class="text-sm text-gray-800 whitespace-pre-wrap">Commission details will appear here.</p>
          </div>
        </div>
      </div>
      
      <!-- Modal footer -->
      <div class="flex items-center justify-end gap-3 p-4 md:p-5 border-t border-gray-200">
        <button type="button" onclick="closeArchiveModal()" class="py-2.5 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
          Close
        </button>
        <button type="button" id="view-messages-btn" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5">
          <svg class="w-4 h-4 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
          </svg>
          View Messages
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  let currentCommissionId = null;
  
  function showArchiveDetails(id, status, address, details, date, price, client) {
    currentCommissionId = id;
    
    // Update modal content
    document.getElementById('modal-commission-address').textContent = address || 'Commission Details';
    document.getElementById('modal-commission-id').textContent = `#${id}`;
    document.getElementById('modal-status-text').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    document.getElementById('modal-details').textContent = details || 'No details provided';
    document.getElementById('modal-date').textContent = date;
    document.getElementById('modal-price').textContent = price.startsWith('PHP') ? price : `PHP${price}`;
    document.getElementById('modal-client').textContent = client;
    
    // Set status indicator and badge color
    const statusIndicator = document.getElementById('modal-status-indicator');
    const statusBadge = document.getElementById('modal-status-badge');
    
    switch(status) {
      case 'completed':
        statusIndicator.className = 'w-2.5 h-2.5 rounded-full me-1.5 bg-blue-500';
        statusBadge.className = 'inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800';
        break;
      case 'cancelled':
        statusIndicator.className = 'w-2.5 h-2.5 rounded-full me-1.5 bg-red-500';
        statusBadge.className = 'inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-800';
        break;
      default:
        statusIndicator.className = 'w-2.5 h-2.5 rounded-full me-1.5 bg-gray-500';
        statusBadge.className = 'inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800';
    }
    
    // Set up the View Messages button
    const viewMessagesBtn = document.getElementById('view-messages-btn');
    viewMessagesBtn.onclick = function() {
      window.location.href = `/inbox?commission=${id}`;
    };
    
    // Show the modal with animation
    const modal = document.getElementById('archiveModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
      const modalContent = modal.querySelector('.relative');
      modalContent.classList.add('scale-100', 'opacity-100');
      modalContent.classList.remove('scale-95', 'opacity-0');
    }, 50);
  }
  
  function closeArchiveModal() {
    const modal = document.getElementById('archiveModal');
    const modalContent = modal.querySelector('.relative');
    
    // Hide with animation
    modalContent.classList.add('scale-95', 'opacity-0');
    modalContent.classList.remove('scale-100', 'opacity-100');
    
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 300);
    
    currentCommissionId = null;
  }
  
  // Close modal when clicking Escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && !document.getElementById('archiveModal').classList.contains('hidden')) {
      closeArchiveModal();
    }
  });

  // Function to show messages (existing function)
  function showMessages(commissionId) {
    // Redirect to inbox with commission ID
    window.location.href = `/inbox?commission=${commissionId}`;
  }
</script>

<style>
  /* Modal animation */
  .relative {
    transition: opacity 0.3s ease, transform 0.3s ease;
    transform: scale(0.95);
    opacity: 0;
  }
  
  .scale-100 {
    transform: scale(1);
  }
  
  .opacity-100 {
    opacity: 1;
  }
  
  .scale-95 {
    transform: scale(0.95);
  }
  
  .opacity-0 {
    opacity: 0;
  }
</style>