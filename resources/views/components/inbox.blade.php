<div class="flex">
  <div class="ml-8 mr-20 px-4 sm:pl-6 w-[525px]">
    <div class="flex flex-col">
      <div class="-m-1.5">
        <div class="p-1.5 min-w-full inline-block align-middle" id="inbox-container">
          @include('components.inbox-content', ['commissions' => $commissions])
        </div>
      </div>
    </div>
  </div>

  <div id="messages-container" class="w-[555px]">
    <div class="flex flex-col items-center justify-center align-center w-full h-[763px] border border-gray-200 shadow-sm rounded-[12px] bg-white">
      <div class="flex flex-col items-center justify-center text-center p-6">
        <img src="load.svg" alt="No conversation selected" class="w-[100px] h-[100px] mb-4 opacity-70" />
        <p class="mb-2 text-gray-500 font-bold text-lg">No Conversation Selected</p>
        <p class="text-gray-400 max-w-xs">Please select a commission thread from the sidebar to view your messages</p>
      </div>
    </div>
  </div>
</div>

<script>
let lastMessageId = 0;
let pendingCommissionSelection = null;

document.addEventListener('DOMContentLoaded', function() {
    // Check for commission parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    const commissionId = urlParams.get('commission');
    
    if (commissionId) {
        // Store the ID to select after rows are loaded
        pendingCommissionSelection = commissionId;
        
        // Try to find it now (it might already be loaded)
        trySelectCommission(commissionId);
    }
});

// Function to try selecting a commission
function trySelectCommission(commissionId) {
    const commissionRow = document.querySelector(`tr[data-commission-id="${commissionId}"]`);
    
    if (commissionRow) {
        // Found it! Simulate a click
        commissionRow.click();
        
        // Add a visual indicator to highlight the selected commission
        commissionRow.classList.add('bg-blue-50');
        
        // Scroll the commission into view if needed
        commissionRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Clear the pending selection since we've handled it
        pendingCommissionSelection = null;
        
        return true;
    }
    
    return false;
}

function showMessages(commissionId) {
    // Add loading state
    const messagesContainer = document.getElementById('messages-container');
    messagesContainer.innerHTML = `
        <div class="flex flex-col items-center justify-center align-center w-full h-[763px] border border-gray-200 shadow-sm rounded-[12px] bg-white">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
            <p class="mt-4 text-gray-500">Loading conversation...</p>
        </div>
    `;
    
    fetch(`/commissions/${commissionId}/messages`)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched messages:', data);
            messagesContainer.setAttribute('data-commission-id', commissionId);
            messagesContainer.innerHTML = data.html;

            // Update lastMessageId
            const lastMessage = data.messages && data.messages.length > 0 ? data.messages[data.messages.length - 1] : null;
            if (lastMessage) {
                lastMessageId = lastMessage.id;
            }

            // Enable "Enter" to send messages
            const messageContent = document.getElementById('message-content');
            if (messageContent) {
                messageContent.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });
            }

            // File input styling and preview
            const fileInput = document.getElementById('attachment');
            const fileButton = document.getElementById('attachment-button');
            if (fileInput && fileButton) {
                fileButton.addEventListener('click', () => {
                    fileInput.click();
                });
                
                fileInput.addEventListener('change', (e) => {
                    displayAttachedFiles();
                    
                    // Enable send button if files are selected
                    const sendButton = document.getElementById('send-button');
                    if (sendButton && fileInput.files.length > 0) {
                        sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        sendButton.removeAttribute('disabled');
                    }
                });
            }
            
            // Monitor message input for enabling/disabling send button
            if (messageContent) {
                messageContent.addEventListener('input', () => {
                    const sendButton = document.getElementById('send-button');
                    if (sendButton) {
                        if (messageContent.value.trim() || (fileInput && fileInput.files.length > 0)) {
                            sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
                            sendButton.removeAttribute('disabled');
                        } else {
                            sendButton.classList.add('opacity-50', 'cursor-not-allowed');
                            sendButton.setAttribute('disabled', 'disabled');
                        }
                    }
                });
            }

            // Set scroll position to the bottom after the next tick
            setTimeout(() => {
                const messagesDiv = messagesContainer.querySelector('div.overflow-y-auto');
                if (messagesDiv) {
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                }
            }, 0);

            // Mark messages as read
            fetch(`/commissions/${commissionId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    console.log("✅ Messages marked as read successfully.");
                    // Update the UI to reflect the read status
                    const unreadMessages = messagesContainer.querySelectorAll('.unread');
                    unreadMessages.forEach(message => {
                        message.classList.remove('unread');
                        message.classList.add('read');
                        const statusElement = message.querySelector('.status');
                        if (statusElement) {
                            statusElement.textContent = '✓ Seen';
                        }
                    });
                } else {
                    console.error("❌ Failed to mark messages as read.");
                }
            })
            .catch(error => console.error("❌ Fetch error:", error));
        })
        .catch(error => console.error("❌ Fetch error:", error));
}

// Add this: A mutation observer to watch for dynamically added commission rows
function setupCommissionRowsObserver() {
    const targetNode = document.getElementById('inbox-container');
    if (!targetNode) return;
    
    const config = { childList: true, subtree: true };
    
    const callback = function(mutationsList, observer) {
        for (const mutation of mutationsList) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0 && pendingCommissionSelection) {
                // New elements were added, try selecting our commission again
                if (trySelectCommission(pendingCommissionSelection)) {
                    // Success! No need to keep watching
                    observer.disconnect();
                }
            }
        }
    };
    
    const observer = new MutationObserver(callback);
    observer.observe(targetNode, config);
}

// Start watching for dynamically added rows as soon as possible
document.addEventListener('DOMContentLoaded', setupCommissionRowsObserver);

function pollMessages() {
    const messagesContainer = document.getElementById('messages-container');
    const commissionId = messagesContainer.getAttribute('data-commission-id');

    if (!commissionId) {
        // No commission selected, nothing to poll
        return;
    }

    fetch(`/commissions/${commissionId}/latest-messages`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched latest messages:', data);
            if (data.latestMessage && data.latestMessage.id > lastMessageId) {
                const existingMessage = document.querySelector(`tr[data-message-id="${data.latestMessage.id}"]`);
                if (!existingMessage) {
                    document.getElementById('messages-tbody').insertAdjacentHTML('beforeend', data.html);
                    lastMessageId = data.latestMessage.id;
                    
                    // Scroll to the new message
                    const messagesDiv = messagesContainer.querySelector('div.overflow-y-auto');
                    if (messagesDiv) {
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                    }
                }
            }
        })
        .catch(error => console.error('Error fetching latest messages:', error));
}

setInterval(pollMessages, 5000);

function sendMessage() {
    console.log("🔵 sendMessage() function called.");

    const messagesContainer = document.getElementById('messages-container');

    if (!messagesContainer) {
        console.error("❌ Error: #messages-container not found.");
        return;
    }

    if (!messagesContainer.hasAttribute('data-commission-id')) {
        console.error("❌ Error: No commission selected before sending message.");
        return;
    }

    const commissionId = messagesContainer.getAttribute('data-commission-id');
    console.log("✅ commissionId retrieved:", commissionId);

    const messageInput = document.getElementById('message-content');
    if (!messageInput) {
        console.error("❌ Error: Message input box not found.");
        return;
    }

    const content = messageInput.value.trim();
    const attachmentInput = document.getElementById('attachment');
    const formData = new FormData();

    if (content) {
        formData.append('content', content);
    }

    if (attachmentInput && attachmentInput.files.length > 0) {
        console.log("📎 Attachments found:", attachmentInput.files.length);
        for (let i = 0; i < attachmentInput.files.length; i++) {
            console.log(`- ${attachmentInput.files[i].name}`);
            formData.append('attachments[]', attachmentInput.files[i]);
        }
    } else {
        console.log("📎 No attachments found.");
    }

    if (!content && (!attachmentInput || attachmentInput.files.length === 0)) {
        console.warn("⚠️ Warning: Empty message and no attachments.");
        return;
    }

    // Disable send button and show sending state
    const sendButton = document.getElementById('send-button');
    if (sendButton) {
        sendButton.setAttribute('disabled', 'disabled');
        sendButton.classList.add('opacity-50');
        sendButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Sending...
        `;
    }

    console.log("📤 Sending message...");
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
            console.log("✅ Message sent successfully:", data);

            const messagesTable = document.querySelector('#messages-tbody');
            if (!messagesTable) {
                console.error("❌ Error: Messages table not found.");
                return;
            }

            // Let the next polling cycle handle displaying the message
            lastMessageId = data.message.id - 1; // Force the message to be picked up

            messageInput.value = '';
            if (attachmentInput) attachmentInput.value = '';

            // Clear the attached files display
            const attachedFilesContainer = document.getElementById('attached-files');
            if (attachedFilesContainer) {
                attachedFilesContainer.innerHTML = '';
            }
            
            // Reset send button
            if (sendButton) {
                sendButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                `;
                sendButton.classList.add('opacity-50', 'cursor-not-allowed');
                sendButton.setAttribute('disabled', 'disabled');
            }
        } else {
            console.error("❌ Error: Message not sent successfully:", data);
            // Reset send button on error
            if (sendButton) {
                sendButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                `;
                sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
                sendButton.removeAttribute('disabled');
            }
        }
    })
    .catch(error => {
        console.error("❌ Fetch error:", error);
        // Reset send button on error
        if (sendButton) {
            sendButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                </svg>
            `;
            sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
            sendButton.removeAttribute('disabled');
        }
    });
}

function displayAttachedFiles() {
    const attachmentInput = document.getElementById('attachment');
    const attachedFilesContainer = document.getElementById('attached-files');

    if (!attachmentInput || !attachedFilesContainer) {
        console.error("❌ Error: Attachment input or attached files container not found.");
        return;
    }

    attachedFilesContainer.innerHTML = ''; // Clear previous attachments

    if (attachmentInput.files.length === 0) {
        attachedFilesContainer.classList.add('hidden');
        return;
    }
    
    attachedFilesContainer.classList.remove('hidden');

    for (let i = 0; i < attachmentInput.files.length; i++) {
        const file = attachmentInput.files[i];
        console.log(`📎 File selected: ${file.name}`);
        
        // Create file preview element
        const fileElement = document.createElement('div');
        fileElement.className = 'flex items-center gap-2 bg-gray-100 rounded-md p-2 text-sm';
        
        // Determine icon based on file type
        let iconSvg = '';
        const fileExt = file.name.split('.').pop().toLowerCase();
        
        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
            iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>';
        } else if (['pdf'].includes(fileExt)) {
            iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>';
        } else if (['doc', 'docx', 'txt'].includes(fileExt)) {
            iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>';
        } else {
            iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>';
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
            <span class="truncate max-w-[120px]">${file.name}</span>
            <span class="text-xs text-gray-500">(${fileSize})</span>
            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeFile(${i})">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        
        attachedFilesContainer.appendChild(fileElement);
    }
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
    
    // Update send button state
    const messageContent = document.getElementById('message-content');
    const sendButton = document.getElementById('send-button');
    
    if (sendButton) {
        if ((messageContent && messageContent.value.trim()) || attachmentInput.files.length > 0) {
            sendButton.classList.remove('opacity-50', 'cursor-not-allowed');
            sendButton.removeAttribute('disabled');
        } else {
            sendButton.classList.add('opacity-50', 'cursor-not-allowed');
            sendButton.setAttribute('disabled', 'disabled');
        }
    }
}
</script>

<style>
  ::-webkit-scrollbar {
    width: 6px;
  }

  ::-webkit-scrollbar-thumb {
    background: rgba(100, 100, 100, 0.5);
    border-radius: 12px;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: rgba(100, 100, 100, 0.8);
  }

  ::-webkit-scrollbar-track {
    background: transparent;
  }

  * {
    scrollbar-width: thin;
    scrollbar-color: rgba(100, 100, 100, 0.5) transparent;
  }
  
  /* Message bubble animations */
  @keyframes messageIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  .message-row {
    animation: messageIn 0.3s ease-out;
  }
</style>