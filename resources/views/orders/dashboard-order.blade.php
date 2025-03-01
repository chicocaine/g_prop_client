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
    <div class="fixed inset-0 bg-black opacity-50"></div> <!-- Overlay -->
    <div class="relative top-20 mx-auto p-5 w-[554px] shadow-lg rounded-md bg-white">
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