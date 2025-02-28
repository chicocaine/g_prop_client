<div class="flex flex-col justify-between h-[750px] bg-white border border-gray-200 dark:bg-gray-800" data-commission-id="{{ $commissionId }}">
    <div class="w-[500px] overflow-y-auto overflow-x-hidden"> <!-- Added overflow-x-hidden -->
        <div class="flex flex-col">
            <div class="w-[500px]">
                <div class="min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @foreach ($messages as $message)
                                    <tr class="bg-white hover:bg-gray-100 dark:bg-neutral-900 shadow-sm mb-[1px] dark:hover:bg-neutral-800">
                                        <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 dark:text-neutral-200" style="word-break: break-word;">
                                            @if ($message->user->is_admin)
                                                <p class="font-bold">Admin:</p>
                                                {{ $message->content }}
                                            @else
                                            <div class="flex justify-end">
                                                <p class="font-bold">{{ $message->user->first_name }} {{ $message->user->last_name }}:</p>
                                            </div>
                                            <div class="flex justify-end">
                                                {{ $message->content }}
                                            </div>
                                            @endif
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

    <div class="bg-[#D3D9E1] h-[159px] rounded-[18px]">
        <div class="relative">
            <textarea id="message-content" class="h-[159px] p-4 pb-12 block w-full bg-gray-100 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Enter message"></textarea>
            <div class="absolute bottom-px inset-x-px p-2 rounded-b-lg bg-gray-100 dark:bg-neutral-800">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                    </div>
                    <div class="flex items-center gap-x-1">
                        <button type="button" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-gray-500 hover:bg-gray-100 focus:z-10 focus:outline-none focus:bg-gray-100 dark:text-neutral-500 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                        </button>
                        <button type="button" onclick="sendMessage()" class="inline-flex shrink-0 justify-center items-center size-8 rounded-lg text-white bg-blue-600 hover:bg-blue-500 focus:z-10 focus:outline-none focus:bg-blue-500">
                            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

