<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

<nav class="ml-20 fixed top-0 left-0 w-full flex items-center align-center justify-start px-4 bg-white shadow-md " aria-label="Global">
  <a href="/dashboard" class="text-xl font-bold">
    <img src="logo.svg" alt="logo" width="86px" height="56px">
  </a>

  <div class="mx-[24px] pt-[12px] font-bold">
    <p>COMMISIONS</p>
  </div>

  <div class="w-1/2 mx-[32px] h-[46px]">   
    <label for="global-search" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Search</label>
    <div class="relative">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
      </div>
      <input type="search" id="global-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-[168px] bg-gray-50 focus:ring-blue-500 focus:border-blue-500 " placeholder="Search Commission" required />
    </div>
  </div>

  <div class="flex justify-end mr-32px w-1/6">
    @auth
      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="text-black hover:text-gray-600  focus:outline-none">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('global-search');
    if (!searchInput) return;
    
    // Get the current page type
    const currentPage = document.body.dataset.page || '';
    
    searchInput.addEventListener('input', debounce(function(e) {
        const searchTerm = e.target.value.trim();
        
        // Different search handling based on the current page
        switch(currentPage) {
            case 'inbox':
                searchInbox(searchTerm);
                break;
            case 'archive':
                searchArchive(searchTerm);
                break;
            case 'dashboard':
                searchDashboard(searchTerm);
                break;
            default:
                // Generic search across all content if needed
                performGlobalSearch(searchTerm);
        }
    }, 300));
    
    // Trigger search when Enter is pressed
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const searchTerm = e.target.value.trim();
            performSearch(searchTerm, currentPage);
        }
    });
});

// Debounce function to prevent excessive API calls
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function performSearch(searchTerm, pageType) {
    if (!searchTerm) return;
    
    // Make the search request
    fetch(`/search?q=${encodeURIComponent(searchTerm)}&type=${pageType}`)
        .then(response => response.json())
        .then(data => {
            // Dispatch a custom event that page-specific scripts can listen for
            document.dispatchEvent(new CustomEvent('searchResults', {
                detail: { results: data, type: pageType }
            }));
        })
        .catch(error => console.error('Search error:', error));
}

function searchInbox(term) {
    if (!term) {
        // If search term is empty, show all commission threads
        document.querySelectorAll('#inbox-container tr').forEach(row => {
            row.style.display = '';
        });
        return;
    }
    
    // Filter the visible rows in the inbox
    document.querySelectorAll('#inbox-container tr').forEach(row => {
        const content = row.textContent.toLowerCase();
        row.style.display = content.includes(term.toLowerCase()) ? '' : 'none';
    });
}

function searchArchive(term) {
    if (!term) {
        // If search term is empty, show all archive items
        document.querySelectorAll('.bg-white.border.border-gray-200.rounded-xl table tbody tr').forEach(row => {
            row.style.display = '';
        });
        return;
    }
    
    // Filter the visible rows in the archive
    document.querySelectorAll('.bg-white.border.border-gray-200.rounded-xl table tbody tr').forEach(row => {
        const content = row.textContent.toLowerCase();
        row.style.display = content.includes(term.toLowerCase()) ? '' : 'none';
    });
}

function searchDashboard(term) {
    if (!term) {
        // If search term is empty, show all dashboard table rows
        document.querySelectorAll('#dashboard-tbody .dashboard-item').forEach(row => {
            row.style.display = '';
        });
        return;
    }
    
    // Filter the visible rows in the dashboard table
    document.querySelectorAll('#dashboard-tbody .dashboard-item').forEach(row => {
        const content = row.textContent.toLowerCase();
        row.style.display = content.includes(term.toLowerCase()) ? '' : 'none';
    });
}

function performGlobalSearch(term) {
    // For searching across all possible content types
    fetch(`/global-search?q=${encodeURIComponent(term)}`)
        .then(response => response.json())
        .then(data => {
            // Handle the results based on the current page
            const currentPage = document.body.dataset.page || '';
            document.dispatchEvent(new CustomEvent('globalSearchResults', {
                detail: { results: data, page: currentPage }
            }));
        })
        .catch(error => console.error('Global search error:', error));
}
</script>