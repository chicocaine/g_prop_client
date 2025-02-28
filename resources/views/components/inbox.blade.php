<div class="flex">

<div class="ml-8 mr-20 px-4  sm:pl-6  w-[525px]">
  <div class="flex flex-col">
    <div class="-m-1.5">
      <div class="p-1.5 min-w-full inline-block align-middle"  id="inbox-container">
        @include('components.inbox-content', ['commissions' => $commissions])

      </div>
    </div>
  </div>
</div>

<div id="messages-container">
  <div class="flex flex-col items-center justify-center align-center w-[555px] h-[763px] border border-gray-50 shadow-sm dark:border-neutral-700 rounded-[12px]">
    <img src="load.svg" alt="No conversation selected" class="w-[77px] h-[77px]" />

    <p class="my-8 text-gray-500 dark:text-neutral-400 font-bold">No Conversation Selected Yet.</p>
    <p >Please Select a Commission Thread</p>
  </div>
</div>

<script>
  function showMessages(commissionId) {
    fetch(`/commissions/${commissionId}/messages`)
      .then(response => response.json())
      .then(data => {
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.setAttribute('data-commission-id', commissionId);
        messagesContainer.innerHTML = data.html;

        // Add event listener to the textarea for the "Enter" key press
        const messageContent = document.getElementById('message-content');
        if (messageContent) {
          messageContent.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
              e.preventDefault();
              sendMessage();
            }
          });
        }

        setTimeout(() => {
          const messagesDiv = messagesContainer.querySelector('div.overflow-y-auto');
          if (messagesDiv) {
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
          }
        }, 100); 
      });
  }

  function sendMessage() {
    const content = document.getElementById('message-content').value;
    const commissionId = document.getElementById('messages-container').getAttribute('data-commission-id');

    fetch(`/commissions/${commissionId}/messages`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ content })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const messagesContainer = document.querySelector('#messages-container tbody');
        const formattedContent = data.message.content.replace(/\n/g, '<br>'); // Replace new lines with <br> tags
        messagesContainer.innerHTML += `
          <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 shadow-sm mb-[1px] dark:hover:bg-neutral-800">
            <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 dark:text-neutral-200" style="word-break: break-word;">
              <p class="text-right font-bold"> ${data.message.user.first_name}: ${data.message.user.last_name} </p>
              <p class="text-right">${formattedContent} </p>
            </td>
          </tr>
        `;
        document.getElementById('message-content').value = '';

        const messagesDiv = document.querySelector('#messages-container div.overflow-y-auto');
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
      }
    });
  }
</script>
</div>

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