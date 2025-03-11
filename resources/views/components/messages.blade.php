<div class="flex flex-col justify-between h-[750px] bg-white border border-gray-200 rounded-[12px]" data-commission-id="{{ $commissionId }}">
    <!-- Chat Header -->
    <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                @if(isset($commission))
                    {{ substr($commission->subject, 0, 1) }}{{ $commissionId }}
                @else
                    C{{ $commissionId }}
                @endif
            </div>
            <div>
                <h3 class="font-semibold">
                    @if(isset($commission))
                        {{ $commission->subject }}
                    @else
                        Commission #{{ $commissionId }}
                    @endif
                </h3>
                <p class="text-xs text-gray-500">
                    @if(isset($commission))
                        Started on {{ $commission->created_at->format('M d, Y') }}
                    @endif
                </p>
            </div>
        </div>
        @if(isset($commission) && isset($commission->status))
            <div class="flex items-center">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    {{ $commission->status === 'active' ? 'bg-green-100 text-green-800' : 
                       ($commission->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                       ($commission->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                    {{ ucfirst($commission->status) }}
                </span>
            </div>
        @endif
    </div>

    <!-- Messages List -->
    <div class="w-[500px] overflow-y-auto overflow-x-hidden flex-1 bg-gray-50 p-2">
        <div class="flex flex-col">
            <div class="w-[500px]">
                <div class="min-w-full inline-block align-middle">
                    <div class="bg-transparent">
                        <table class="min-w-full">
                            <tbody id="messages-tbody">
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

    <!-- Message Input Area -->
    <div class="bg-white border-t border-gray-200 p-3">
        <!-- Attached Files Preview -->
        <div id="attached-files" class="flex flex-wrap gap-2 mb-2 px-2 max-h-24 overflow-y-auto"></div>

        <div class="relative rounded-lg border border-gray-300 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
            <!-- Message Textarea -->
            <textarea 
                id="message-content" 
                class="p-3 pr-20 pb-10 block w-full border-0 bg-transparent rounded-lg resize-none text-sm focus:outline-none" 
                placeholder="Type your message here... (or just attach files)"
                rows="3"
            ></textarea>
            
            <!-- Action Buttons -->
            <div class="absolute bottom-1 right-1 flex items-center">
                <!-- Attachment Button -->
                <div class="flex items-center mr-1">
                    <input type="file" id="attachment" class="hidden" multiple onchange="displayAttachedFiles()">
                    <button 
                        id="attachment-button" 
                        type="button" 
                        onclick="document.getElementById('attachment').click()" 
                        class="inline-flex justify-center items-center p-2 rounded-full text-gray-500 hover:bg-gray-100 focus:outline-none transition-colors"
                    >
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.44 11.05L12.25 20.24a6 6 0 0 1-8.49-8.49L12.33 3.18A4 4 0 1 1 18 8.84L9.41 17.41a2 2 0 0 1-2.83-2.83L15.07 6.18"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Send Button -->
                <button 
                    id="send-button" 
                    type="button" 
                    onclick="sendMessage()" 
                    class="inline-flex justify-center items-center p-2 rounded-full text-white bg-blue-600 hover:bg-blue-500 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    disabled
                >
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    const commissionId = {{ $commissionId }};

    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to bottom of messages on load
        const messagesContainer = document.querySelector('.overflow-y-auto');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        // Enable "Enter" to send messages
        const messageContent = document.getElementById('message-content');
        if (messageContent) {
            messageContent.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            
            // Update send button state based on content
            messageContent.addEventListener('input', updateSendButtonState);
        }
    });

    function pollMessages() {
        fetch(`/commissions/${commissionId}/latest-messages`)
            .then(response => response.json())
            .then(data => {
                if (data.latestMessage && data.latestMessage.id > lastMessageId) {
                    const existingMessage = document.querySelector(`tr[data-message-id="${data.latestMessage.id}"]`);
                    if (!existingMessage) {
                        document.getElementById('messages-tbody').insertAdjacentHTML('beforeend', data.html);
                        lastMessageId = data.latestMessage.id;
                        
                        // Scroll to bottom when new message arrives
                        const messagesContainer = document.querySelector('.overflow-y-auto');
                        if (messagesContainer) {
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                    }
                }
            })
            .catch(error => console.error('Error fetching latest messages:', error));
    }

    function displayAttachedFiles() {
        const attachmentInput = document.getElementById('attachment');
        const attachedFilesContainer = document.getElementById('attached-files');

        if (!attachmentInput || !attachedFilesContainer) return;

        attachedFilesContainer.innerHTML = ''; // Clear previous attachments

        if (attachmentInput.files.length === 0) {
            attachedFilesContainer.classList.add('hidden');
            updateSendButtonState();
            return;
        }
        
        attachedFilesContainer.classList.remove('hidden');

        for (let i = 0; i < attachmentInput.files.length; i++) {
            const file = attachmentInput.files[i];
            
            // Create file preview element
            const fileElement = document.createElement('div');
            fileElement.className = 'flex items-center gap-2 bg-gray-100 rounded-md p-1.5 text-sm';
            
            // Determine icon based on file type
            let iconSvg = '';
            const fileExt = file.name.split('.').pop().toLowerCase();
            
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                iconSvg = '<svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>';
            } else if (['pdf'].includes(fileExt)) {
                iconSvg = '<svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>';
            } else if (['doc', 'docx', 'txt'].includes(fileExt)) {
                iconSvg = '<svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
            } else {
                iconSvg = '<svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>';
            }
            
            // Calculate file size
            let fileSize = '';
            if (file.size < 1024) {
                fileSize = `${file.size} B`;
            } else if (file.size < 1024 * 1024) {
                fileSize = `${(file.size / 1024).toFixed(1)} KB`;
            } else {
                fileSize = `${(file.size / (1024 * 1024)).toFixed(1)} MB`;
            }
            
            fileElement.innerHTML = `
                ${iconSvg}
                <span class="truncate max-w-[100px]">${file.name}</span>
                <span class="text-xs text-gray-500">${fileSize}</span>
                <button type="button" class="text-gray-500 hover:text-red-500" onclick="removeFile(${i})">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            attachedFilesContainer.appendChild(fileElement);
        }
        
        updateSendButtonState();
    }

    function removeFile(index) {
        const attachmentInput = document.getElementById('attachment');
        if (!attachmentInput || !attachmentInput.files || attachmentInput.files.length <= index) {
            return;
        }
        
        // Files can't be removed directly from a FileList, so we need to create a new one
        const dt = new DataTransfer();
        
        for (let i = 0; i < attachmentInput.files.length; i++) {
            if (i !== index) {
                dt.items.add(attachmentInput.files[i]);
            }
        }
        
        attachmentInput.files = dt.files;
        displayAttachedFiles();
    }

    function updateSendButtonState() {
        const messageContent = document.getElementById('message-content');
        const attachmentInput = document.getElementById('attachment');
        const sendButton = document.getElementById('send-button');
        
        if (!sendButton) return;
        
        // Enable button if there's message content or attachments
        if ((messageContent && messageContent.value.trim()) || 
            (attachmentInput && attachmentInput.files && attachmentInput.files.length > 0)) {
            sendButton.disabled = false;
        } else {
            sendButton.disabled = true;
        }
    }

    function sendMessage() {
        const messageContent = document.getElementById('message-content');
        const attachmentInput = document.getElementById('attachment');
        const sendButton = document.getElementById('send-button');
        
        if (!messageContent) return;
        
        const content = messageContent.value.trim();
        
        // Check if there's anything to send
        if (!content && (!attachmentInput || !attachmentInput.files || attachmentInput.files.length === 0)) {
            return;
        }
        
        // Disable button and show loading state
        if (sendButton) {
            sendButton.disabled = true;
            sendButton.innerHTML = `
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
        }
        
        // Create form data
        const formData = new FormData();
        if (content) {
            formData.append('content', content);
        }
        
        if (attachmentInput && attachmentInput.files) {
            for (let i = 0; i < attachmentInput.files.length; i++) {
                formData.append('attachments[]', attachmentInput.files[i]);
            }
        }
        
        // Send the message
        fetch(`/commissions/${commissionId}/messages`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear the form
                messageContent.value = '';
                if (attachmentInput) attachmentInput.value = '';
                
                // Clear attached files display
                const attachedFilesContainer = document.getElementById('attached-files');
                if (attachedFilesContainer) {
                    attachedFilesContainer.innerHTML = '';
                    attachedFilesContainer.classList.add('hidden');
                }
                
                // Let polling handle the new message display
                lastMessageId = data.message.id - 1;
                
                // Reset send button
                if (sendButton) {
                    sendButton.innerHTML = `
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    `;
                    sendButton.disabled = true;
                }
            } else {
                // Handle error
                console.error('Error sending message:', data);
                
                // Reset send button
                if (sendButton) {
                    sendButton.innerHTML = `
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    `;
                    updateSendButtonState();
                }
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            
            // Reset send button
            if (sendButton) {
                sendButton.innerHTML = `
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                `;
                updateSendButtonState();
            }
        });
    }

    // Start polling for new messages
    setInterval(pollMessages, 5000);
</script>

<style>
    /* Smooth scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.7);
    }
    
    /* Message animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    #messages-tbody tr:last-child {
        animation: fadeIn 0.3s ease-out;
    }
</style>