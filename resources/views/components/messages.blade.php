<div class="flex flex-col justify-between h-[750px] bg-[#F7F7F7] dark:bg-gray-800">
    <div class="w-[500px] overflow-y-auto">
    <div class="flex flex-col">
        <div class=" w-[500px]">
        <div class=" min-w-full inline-block align-middle">
            <div class="bg-white border border-gray-200  shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                @foreach ($messages as $message)
                    <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800">
                    <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 dark:text-neutral-200" style="word-break: break-word;">
                        @if ($message->user->is_admin)
                        Admin:
                        @else
                        {{ $message->user->first_name }} {{ $message->user->last_name }}:
                        @endif
                        {{ $message->content }}
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
     Message shit
    </div>
</div>