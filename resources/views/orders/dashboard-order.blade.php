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
            <x-inbox :commissions="$commissions"/>
        @elseif($view === 'archive')
            <x-archive :commissions="$commissions"/>
        @endif
    </div>
</div>

<!-- FAQ Modal -->
<div id="faqModal" class="fixed inset-0 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Frequently Asked Questions</h3>
            <div class="mt-2">
                @foreach($faqs as $faq)
                    <div class="flex justify-between items-center my-2">
                        <p class="text-sm text-gray-500">{{ $faq->question }}</p>
                        <button onclick="createCommission('{{ $faq->question }}')" class="bg-blue-500 text-white px-3 py-1 rounded">Ask Now</button>
                    </div>
                @endforeach
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="closeFaqModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
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