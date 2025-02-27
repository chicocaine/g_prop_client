<div class="flex">

<div class="ml-8 px-4 py-10 sm:pl-6 lg:py-4 w-[525px]">
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
              @foreach ($commissions as $commission)
                <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 cursor-pointer" onclick="showMessages({{ $commission->id }})">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-neutral-200">
                    {{ $commission->details }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-neutral-400">
                    {{ Str::limit($commission->description, 50) }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="messages-container">
  <!-- Messages will be loaded here -->
</div>

<script>
  function showMessages(commissionId) {
    fetch(`/commissions/${commissionId}/messages`)
      .then(response => response.json())
      .then(data => {
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.innerHTML = data.html;
      });
  }
</script>
</div>