@extends('components.dashboard-layout')

@section('content')
<div class="flex justify-between mt-22">
    <div class="flex w-[325px] min-h-screen bg-white dark:bg-gray-800 justify-end align-center pr-[10px]">
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
                        <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-neutral-200">
                                <img src="${commission.status}.svg" alt="${commission.status.charAt(0).toUpperCase() + commission.status.slice(1)} Logo" width="16px" height="16px">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                                ${commission.id}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                                ${commission.subject || ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                                ${commission.details || ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
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
                                <p class="text-gray-500 dark:text-neutral-400 font-bold">No matching commissions found.</p>
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
</script>
@endsection