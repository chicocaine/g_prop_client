@extends('components.dashboard-layout')

@section('content')
<div class="flex justify-between mt-22">
    <div class="flex w-[325px] min-h-screen bg-white  justify-end align-center pr-[10px]">
        <div class="flex flex-col">
        <a href="{{ route('dashboard') }}">
            <div class="flex justify-start items-center my-4 gap-4 px-4 w-[206px] h-[33px] rounded-[16px] bg-[#D3F3FD]">
                <img src="commission.svg" alt="All Commission Logo" width="18px" height="18px">
                <p class="text-black font-bold">All Commission</p>
            </div>
        </a>
            <p>Filter</p>
            <div class="flex flex-col my-4 pl-8 gap-y-4">
                <a href="{{ route('dashboard', ['status' => 'completed']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="completed.svg" alt="Completed Logo" width="16px" height="16px">
                        Completed
                    </div>
                </a>
                <a href="{{ route('dashboard', ['status' => 'active']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="active.svg" alt="Active Logo" width="16px" height="16px">
                        Active
                    </div>
                </a>
                <a href="{{ route('dashboard', ['status' => 'pending']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="pending.svg" alt="Cancelled Logo" width="16px" height="16px">
                        Pending 
                    </div>
                </a>
                <a href="{{ route('dashboard', ['status' => 'cancelled']) }}">
                    <div class="flex items-center gap-x-2">
                        <img src="cancelled.svg" alt="Cancelled Logo" width="16px" height="16px">
                        Cancelled
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="flex-1 w-[1080px]">
        <x-dashboard.view-table :commissions="$commissions" />
    </div>
</div>

<script>
    // Set page type for search functionality
    document.body.dataset.page = "dashboard";
    
    // Listen for search results
    document.addEventListener('searchResults', function(e) {
        const { results, type } = e.detail;
        
        if (type === 'dashboard') {
            updateDashboardWithResults(results);
        }
    });
    
    function updateDashboardWithResults(results) {
        const tableBody = document.querySelector('.bg-white.border.border-gray-200.rounded-xl table tbody');
        if (!tableBody) return;
        
        if (results.html) {
            tableBody.innerHTML = results.html;
        } else if (results.commissions) {
            if (results.commissions.length > 0) {
                let html = '';
                results.commissions.forEach(commission => {
                    const date = new Date(commission.created_at);
                    const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    
                    html += `
                        <tr class="bg-white hover:bg-gray-50 ">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                                <img src="${commission.status}.svg" alt="${commission.status.charAt(0).toUpperCase() + commission.status.slice(1)} Logo" width="16px" height="16px">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                                ${commission.id}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                                ${commission.subject || ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                                ${commission.details || ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                                ${formattedDate}
                            </td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = html;
            } else {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-4">
                            <div class="flex flex-col items-center justify-center align-center h-[200px]">
                                <p class="text-gray-500  font-bold">No matching commissions found.</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
            
            // Update the results count in the footer
            const resultsCount = document.querySelector('.text-sm.text-gray-600 .font-semibold');
            if (resultsCount) {
                resultsCount.textContent = results.commissions.length;
            }
        }
    }

        function updateDashboardWithResults(results) {
        const dashboardContainer = document.getElementById('dashboard-container');
        if (!dashboardContainer) return;
        
        if (results.html) {
            dashboardContainer.innerHTML = results.html;
        } else if (results.commissions) {
            if (results.commissions.length > 0) {
                // We have search results - render the table
                let tableHtml = `
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800">Status</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800">ID</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800">Subject</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800">Description</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-gray-800">Date</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="dashboard-tbody">`;
                
                results.commissions.forEach(commission => {
                    const date = new Date(commission.created_at);
                    const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    
                    tableHtml += `
                        <tr class="dashboard-item bg-white hover:bg-gray-50 cursor-pointer" 
                            onclick="showCommissionDetails(${commission.id}, '${commission.status}', '${commission.subject?.replace(/'/g, "\\'")}', \`${commission.details?.replace(/`/g, '\\`')}\`, '${formattedDate}', '${commission.set_price || 'Not set'}', '${commission.user ? commission.user.first_name + ' ' + commission.user.last_name : 'Unknown'}')">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <img src="${commission.status}.svg" alt="${commission.status.charAt(0).toUpperCase() + commission.status.slice(1)} Logo" width="16px" height="16px">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${commission.id}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${commission.subject || ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate">
                                ${commission.details ? (commission.details.length > 50 ? commission.details.substring(0, 50) + '...' : commission.details) : ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${formattedDate}
                            </td>
                        </tr>`;
                });
                
                tableHtml += `
                        </tbody>
                    </table>
                    <!-- Footer -->
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold text-gray-800">${results.commissions.length}</span> results
                            </p>
                        </div>
                    </div>`;
                
                dashboardContainer.innerHTML = tableHtml;
                
            } else {
                // No results - show empty state
                dashboardContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 px-4">
                        <img src="empty-search.svg" alt="No results" class="w-40 h-40 mb-4 opacity-70" 
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2NjY2NjYyIgc3Ryb2tlLXdpZHRoPSIxLjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PGNpcmNsZSBjeD0iMTEiIGN5PSIxMSIgcj0iOCI+PC9jaXJjbGU+PGxpbmUgeDE9IjIxIiB5MT0iMjEiIHgyPSIxNi42NSIgeTI9IjE2LjY1Ij48L2xpbmU+PGxpbmUgeDE9IjExIiB5MT0iOCIgeDI9IjExIiB5Mj0iMTQiPjwvbGluZT48bGluZSB4MT0iOCIgeTE9IjExIiB4Mj0iMTQiIHkyPSIxMSI+PC9saW5lPjwvc3ZnPg==';">
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Results Found</h3>
                        <p class="text-gray-500 max-w-md text-center mb-6">
                            We couldn't find any commissions matching your search criteria.
                        </p>
                        <button onclick="window.location.href='${window.location.pathname}'" class="inline-flex items-center gap-x-2 py-2.5 px-4 rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                            </svg>
                            Reset Search
                        </button>
                    </div>`;
            }
        }
    }
</script>
@endsection