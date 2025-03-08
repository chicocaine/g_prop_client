@extends('components.dashboard-layout')

@section('content')
<div class="flex justify-between mt-22">
    <div class="flex w-[325px] min-h-screen bg-white dark:bg-gray-800 justify-end align-center pr-[10px]">
        <div class="flex flex-col pr-4 w-[220px]">
            <button onclick="openFaqModal()" class="flex justify-start items-center my-4 gap-4 px-4 w-[156px] h-[60px] rounded-[16px] bg-[#D3F3FD]">
                <img src="make-commission.svg" alt="All Commission Logo" width="18px" height="18px">
                <p class="text-black font-bold">Make Commission</p>
            </button>    
            <div class="flex justify-start items-center my-4 gap-4 px-4 w-[204px] h-[32px] rounded-[16px] bg-white hover:bg-[#D3F3FD]">
                <a href="{{ route('inbox') }}">
                    <div class="flex items-center gap-x-2">
                        <img src="active-commission.svg" alt="Active Logo" width="16px" height="16p id="inbox-containerx">
                        Active
                    </div>
                </a>
            </div>
            <div class="flex justify-start items-center gap-4 px-4 w-[204px] h-[32px] rounded-[16px] bg-white hover:bg-[#D3F3FD]">
                <a href="{{ route('commissions.archive') }}">
                    <div class="flex items-center gap-x-2">
                        <img src="archive.svg" alt="Archive Logo" width="16px" height="16px">
                        Archive
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="flex-1 w-[1080px]">
        @if($view === 'inbox')
            <p class="text-[22px] text-[#666] ml-16 mb-4">Proposed Commission</p>
            <x-inbox :commissions="$commissions"/>
        @elseif($view === 'archive')
            <p class="text-[22px] text-[#666] ml-16 mb-4">Completed Commission</p>
            <x-archive :commissions="$commissions"/>
        @endif
    </div>
</div>

<!-- FAQ Modal -->
<div id="faqModal" class="fixed inset-0 overflow-y-auto h-full w-full hidden">
    <div class="fixed inset-0 bg-black opacity-50"></div> <!-- Overlay -->
    <div class="relative top-20 mx-auto px-5 pb-5 pt-2 w-[554px] shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="flex justify-end">
                <button onclick="closeFaqModal()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                </button>
            </div>
            <div class="flex justify-between items-center w-[500px]">
                <img src="logo.svg" alt="logo" width="164px" height="164px">
                <div class="flex flex-col w-[300px]">
                <h3 class="text-[24px] leading-6 font-bold text-gray-900">Frequently Asked Questions / Get Started</h3>
                <p>Need help? Start with These Questions</p>
                </div>
                
            </div>
            <hr style="border-color: #D3D9E1;">
            <div class="mt-8">
                @foreach($faqs as $faq)
                    <div class="flex justify-between items-center my-2 mb-4">
                        <p class="text-sm text-gray-500">{{ $faq->question }}</p>
                        <button onclick="createCommission('{{ $faq->question }}')" class="bg-[#f2f6fc]  text-[#666] px-3 py-1 rounded-[19px] w-[124px] h-[38px] flex items-center gap-x-2 hover:bg-[#c2e7ff]">
                            <img src="ask.svg" alt="ask">
                            Ask Now
                        </button>
                    </div>
                @endforeach
                <hr style="border-color: #D3D9E1;">
                <div class="flex flex-col mt-4 my-4 align-start">
                    <div class="flex justify-start">
                    <p>Didn't find what you're looking for? Feel free to ask us directly</p>
                    </div>
                    <div class="flex justify-between items-center">
                    <input type="text" id="customQuestion" class="mt-2 p-2 bg-white border-[1px] border-solid border-[#D3D9E1] rounded-[35px] w-[345px]" placeholder="Enter your question here">
                    <button onclick="createCustomCommission()" class="bg-[#f2f6fc]  text-[#666] px-3 py-1 rounded-[19px] w-[124px] h-[38px] flex items-center gap-x-2 hover:bg-[#c2e7ff]">
                            <img src="ask.svg" alt="ask">
                            Ask Now
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    document.body.dataset.page = "{{ $view }}"; // 'inbox' or 'archive'
    
    // Listen for search events
    document.addEventListener('searchResults', function(e) {
        const { results, type } = e.detail;
        
        if (type === '{{ $view }}') {
            // Update the view with search results
            if (type === 'inbox') {
                updateInboxWithResults(results);
            } else if (type === 'archive') {
                updateArchiveWithResults(results);
            }
        }
    });
    
    function updateInboxWithResults(results) {
        const inboxContainer = document.getElementById('inbox-container');
        if (!inboxContainer) return;
        
        if (results.html) {
            inboxContainer.innerHTML = results.html;
        } else if (results.commissions) {
            // Alternative approach if not returning HTML directly
            // Filter the existing commissions
        }
    }
    
    function updateArchiveWithResults(results) {
        const archiveContainer = document.getElementById('archive-tbody');
        if (!archiveContainer) return;
        
        if (results.html) {
            archiveContainer.innerHTML = results.html;
        } else if (results.commissions) {
            // If no HTML is returned but commissions data is available
            if (results.commissions.length > 0) {
                let html = '';
                results.commissions.forEach(commission => {
                    html += `
                        <tr class="archive-item bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 cursor-pointer" onclick="showMessages(${commission.id})">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-neutral-200">
                                <img src="${commission.status}.svg" alt="${commission.status.charAt(0).toUpperCase() + commission.status.slice(1)} Logo" width="16px" height="16px">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-neutral-200">
                                ${commission.status}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-neutral-200">
                                ${commission.details}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                                ${commission.set_price ? commission.set_price.substring(0, 50) : ''}
                            </td>
                        </tr>
                    `;
                });
                archiveContainer.innerHTML = html;
            } else {
                archiveContainer.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-6 py-4">
                            <div class="flex flex-col items-center justify-center align-center h-[200px]">
                                <p class="text-gray-500 dark:text-neutral-400 font-bold">No matching commissions found.</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }
    }
    function openFaqModal() {
        document.getElementById('faqModal').classList.remove('hidden');
    }

    function closeFaqModal() {
        document.getElementById('faqModal').classList.add('hidden');
    }

        function createCommission(question) {
        fetch('/commissions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                question: question
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close the FAQ modal
                closeFaqModal();
    
                // Reload the inbox
                loadInbox();
            }
        });
    }
     function createCustomCommission() {
        const customQuestion = document.getElementById('customQuestion').value;
        if (customQuestion.trim() === '') {
            alert('Please enter a question.');
            return;
        }
        createCommission(customQuestion);
    }
    
    function loadInbox() {
        fetch('/inbox')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#inbox-content').innerHTML;
                document.querySelector('#inbox-content').innerHTML = newContent;
            });
    }
    
</script>
@endsection