<div class="flex flex-col justify-between h-[750px] bg-white border border-gray-200 " data-commission-id="{{ $commissionId }}">
    <div class="w-[500px] overflow-y-auto overflow-x-hidden">
        <div class="flex flex-col">
            <div class="w-[500px]">
                <div class="min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 ">
                            <tbody class="divide-y divide-gray-200 " id="messages-tbody">
                                @foreach ($messages as $message)
                                    <x-message-row :message="$message"/>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#D3D9E1] h-[159px] rounded-[18px]">
        <div class="relative">
            <div id="attached-files" class="mt-2 px-4"></div> <!-- Container for displaying attached files -->
            <textarea id="message-content" class="h-[159px] p-4 pb-12 block w-full bg-gray-100 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 " placeholder="Enter message"></textarea>
            <div class="absolute bottom-px inset-x-px p-2 rounded-b-lg bg-gray-100 ">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <input type="file" id="attachment" class="hidden" multiple onchange="displayAttachedFiles()">
                        <button type="button" onclick="document.getElementById('attachment').click()" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-none focus:bg-gray-100 ">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05L12.25 20.24a6 6 0 0 1-8.49-8.49L12.33 3.18A4 4 0 1 1 18 8.84L9.41 17.41a2 2 0 0 1-2.83-2.83L15.07 6.18"/></svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-x-1">
                        <button type="button" onclick="sendMessage()" class="w-[122px] h-[33px] rounded-[16px] inline-flex shrink-0 justify-center items-center size-8 text-white bg-blue-600 hover:bg-blue-500 focus:z-10 focus:outline-none focus:bg-blue-500">
                            <svg class="shrink-0 size-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                            </svg>
                            Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    const commissionId = {{ $commissionId }};

    function pollMessages() {
        fetch(`/commissions/${commissionId}/latest-messages`)
            .then(response => response.json())
            .then(data => {
                if (data.latestMessage && data.latestMessage.id > lastMessageId) {
                    const existingMessage = document.querySelector(`tr[data-message-id="${data.latestMessage.id}"]`);
                    if (!existingMessage) {
                        document.getElementById('messages-tbody').insertAdjacentHTML('beforeend', data.html);
                        lastMessageId = data.latestMessage.id;
                    }
                }
            })
            .catch(error => console.error('Error fetching latest messages:', error));
    }

    setInterval(pollMessages, 5000);
</script>