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

  <div id="messages-container">
    <div class="flex flex-col items-center justify-center align-center w-[555px] h-[763px] border border-gray-50 shadow-sm dark:border-neutral-700 rounded-[12px]">
      <img src="load.svg" alt="No conversation selected" class="w-[77px] h-[77px]" />
      <p class="my-8 text-gray-500 dark:text-neutral-400 font-bold">No Conversation Selected Yet.</p>
      <p>Please Select a Commission Thread</p>
    </div>
  </div>
</div>

<script>
let lastMessageId = 0;

function showMessages(commissionId) {
    fetch(`/commissions/${commissionId}/messages`)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched messages:', data); // Log the result
            const messagesContainer = document.getElementById('messages-container');
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
                            statusElement.textContent = '(Seen)';
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

function pollMessages() {
    const messagesContainer = document.getElementById('messages-container');
    const commissionId = messagesContainer.getAttribute('data-commission-id');

    if (!commissionId) {
        console.error('No commission ID');
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
            console.log('Fetched latest messages:', data); // Log the result
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

function sendMessage() {
    console.log("🔵 sendMessage() function called.");

    const messagesContainer = document.getElementById('messages-container');

    if (!messagesContainer) {
        console.error("❌ Error: #messages-container not found.");
        alert("Error: Message container missing.");
        return;
    }

    console.log("✅ messagesContainer found:", messagesContainer);

    if (!messagesContainer.hasAttribute('data-commission-id')) {
        console.error("❌ Error: No commission selected before sending message.");
        alert("Please select a commission thread first.");
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
        console.log("📎 Attachments found:");
        for (let i = 0; i < attachmentInput.files.length; i++) {
            console.log(`- ${attachmentInput.files[i].name}`);
            formData.append('attachments[]', attachmentInput.files[i]);
        }
    } else {
        console.log("📎 No attachments found.");
    }

    if (!content && (!attachmentInput || attachmentInput.files.length === 0)) {
        console.warn("⚠️ Warning: Empty message and no attachments not sent.");
        return;
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

            const messagesTable = document.querySelector('#messages-container tbody');
            if (!messagesTable) {
                console.error("❌ Error: Messages table not found.");
                return;
            }

            const formattedContent = data.message.content ? data.message.content.replace(/\n/g, '<br>') : '';
            let attachmentsHtml = '';
            if (data.attachments && data.attachments.length > 0) {
                attachmentsHtml = '<div class="mt-2">';
                data.attachments.forEach(attachment => {
                    attachmentsHtml += `<a href="${attachment.file_path}" target="_blank" class="text-blue-500 hover:underline">${attachment.file_name}</a>`;
                });
                attachmentsHtml += '</div>';
            }

            messagesTable.innerHTML += `
                <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 shadow-sm mb-[1px] dark:hover:bg-neutral-800" data-message-id="${data.message.id}">
                    <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 dark:text-neutral-200" style="word-break: break-word;">
                        <p class="text-right font-bold">${data.message.user.first_name} ${data.message.user.last_name}:</p>
                        <p class="text-right">${formattedContent}</p>
                        <div class="flex justify-end gap-x-2">
                        ${attachmentsHtml}
                        </div>
                    </td>
                </tr>
            `;

            messageInput.value = '';
            if (attachmentInput) attachmentInput.value = '';

            const messagesDiv = document.querySelector('#messages-container div.overflow-y-auto');
            if (messagesDiv) {
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }

            // Clear the attached files display
            const attachedFilesContainer = document.getElementById('attached-files');
            if (attachedFilesContainer) {
                attachedFilesContainer.innerHTML = '';
            }
        } else {
            console.error("❌ Error: Message not sent successfully:", data);
        }
    })
    .catch(error => console.error("❌ Fetch error:", error));
}

function displayAttachedFiles() {
    const attachmentInput = document.getElementById('attachment');
    const attachedFilesContainer = document.getElementById('attached-files');

    if (!attachmentInput || !attachedFilesContainer) {
        console.error("❌ Error: Attachment input or attached files container not found.");
        return;
    }

    attachedFilesContainer.innerHTML = ''; // Clear previous attachments

    for (let i = 0; i < attachmentInput.files.length; i++) {
        const file = attachmentInput.files[i];
        console.log(`📎 File selected: ${file.name}`);
        const fileElement = document.createElement('div');
        fileElement.textContent = file.name;
        attachedFilesContainer.appendChild(fileElement);
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
</style>